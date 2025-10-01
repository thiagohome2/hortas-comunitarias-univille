<?php

namespace App\Services;

use App\Models\HortaModel;
use App\Repositories\HortaRepository;
use Respect\Validation\Validator as v;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Ramsey\Uuid\Uuid;

class HortaService
{
    protected HortaRepository $hortaRepository;
    protected AssociacaoService $associacaoService;
    protected EnderecoService $enderecoService;
    protected CargoService $cargoService;

    public function __construct(HortaRepository $hortaRepository, AssociacaoService $associacaoService, EnderecoService $enderecoService, CargoService $cargoService)
    {
        $this->hortaRepository = $hortaRepository;
        $this->associacaoService = $associacaoService;
        $this->cargoService = $cargoService;
        $this->enderecoService = $enderecoService;
    }

    public function findAllWhere(array $condition = [], array $payloadUsuarioLogado): Collection
    {
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        
        switch ($cargo) {
            case 'admin_plataforma':
                return $this->hortaRepository->findAllWhere(array_merge(['excluido' => 0], $condition));
                
            case 'admin_associacao_geral':
                return $this->hortaRepository->findAllWhere(array_merge([
                    'excluido' => 0,
                    'associacao_vinculada_uuid' => $payloadUsuarioLogado['associacao_uuid']
                ], $condition));
                
            case 'admin_horta_geral':
            case 'canteirista':
            case 'dependente':
                return $this->hortaRepository->findAllWhere(array_merge([
                    'excluido' => 0,
                    'uuid' => $payloadUsuarioLogado['horta_uuid']
                ], $condition));
                
            default:
                throw new Exception("Permissão insuficiente | findAllWhere");
        }
    }
    
    public function findByUuid(string $uuid, array $payloadUsuarioLogado): ?HortaModel
    {
        $horta = $this->hortaRepository->findByUuid($uuid);
        if (!$horta || $horta->excluido) {
            throw new Exception('Horta não encontrada');
        }
        
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        
        switch ($cargo) {
            case 'admin_plataforma':
                return $horta;
                
            case 'admin_associacao_geral':
                if ($horta->associacao_vinculada_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não tem permissão para acessar esta horta");
                }
                return $horta;
                
            case 'admin_horta_geral':
            case 'canteirista':
            case 'dependente':
                if ($horta->uuid !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você não tem permissão para acessar esta horta");
                }
                return $horta;
                
            default:
                throw new Exception("Permissão insuficiente | findByUuid");
        }
    }

    public function create(array $data, array $payloadUsuarioLogado): HortaModel
    {
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);

        switch ($cargo) { 
            case 'admin_plataforma':
                // Pode criar horta para qualquer associação
                break;
                
            case 'admin_associacao_geral':
                // Só pode criar horta para sua própria associação
                if (!empty($data['associacao_vinculada_uuid']) && $data['associacao_vinculada_uuid'] !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você só pode criar hortas para sua própria associação");
                }
                break;
                
            default:
                throw new Exception("Permissão insuficiente 0,1 | create");
        }
        
        v::key('nome_da_horta', v::stringType()->notEmpty())
        ->key('percentual_taxa_associado', v::floatVal()->between(0, 100, true))
        ->key('associacao_vinculada_uuid', v::uuid())
        ->key('tipo_de_liberacao', V::intVal()->min(1)->max(3))
        ->key('endereco_uuid', v::uuid())
        ->assert($data);
        
        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);
        
        $data['uuid'] = Uuid::uuid1()->toString();
        $data['usuario_criador_uuid'] =  $payloadUsuarioLogado['usuario_uuid'];
        $data['usuario_alterador_uuid'] =  $payloadUsuarioLogado['usuario_uuid'];

        if (!empty($data['associacao_vinculada_uuid'])){
            $this->associacaoService->findByUuid($data['associacao_vinculada_uuid'], $payloadUsuarioLogado);
        }

        if (!empty($data['endereco_uuid'])) {
            $this->enderecoService->findByUuid($data['endereco_uuid']);
        }

        return $this->hortaRepository->create($data);
    }

    public function update(string $uuid, array $data, array $payloadUsuarioLogado): HortaModel
    {
        $horta = $this->hortaRepository->findByUuid($uuid);
        if (!$horta || $horta->excluido) {
            throw new Exception('Horta não encontrada');
        }
        
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        
        switch ($cargo) { 
            case 'admin_plataforma':
                // Pode editar qualquer horta
                break;
                
            case 'admin_associacao_geral':
                // Só pode editar hortas da sua associação
                if ($horta->associacao_vinculada_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não tem permissão para editar esta horta");
                }
                break;
                
            case 'admin_horta_geral':
                // Só pode editar sua própria horta
                if ($horta->uuid !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você não tem permissão para editar esta horta");
                }
                break;
                
            default:
                throw new Exception("Permissão insuficiente 0,1,2 | update");
        }
        
        v::key('nome_da_horta', v::stringType()->notEmpty(), false)
        ->key('percentual_taxa_associado', v::floatVal()->between(0, 100, true), false)
        ->key('associacao_vinculada_uuid', v::uuid(), false)
        ->key('tipo_de_liberacao', V::intVal()->min(1)->max(3), false)
        ->key('endereco_uuid', v::uuid(), false)
        ->assert($data);

        $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];

        return $this->hortaRepository->update($horta, $data);
    }

    public function delete(string $uuid, array $payloadUsuarioLogado): bool {
        $horta = $this->hortaRepository->findByUuid($uuid);
        if (!$horta || $horta->excluido) {
            throw new Exception('Horta não encontrada');
        }
        
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        
        switch ($cargo) { 
            case 'admin_plataforma':
                // Pode deletar qualquer horta
                break;
                
            case 'admin_associacao_geral':
                // Só pode deletar hortas da sua associação
                if ($horta->associacao_vinculada_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não tem permissão para deletar esta horta");
                }
                break;
                
            case 'admin_horta_geral':
                // Só pode deletar sua própria horta
                if ($horta->uuid !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você não tem permissão para deletar esta horta");
                }
                break;
                
            default:
                throw new Exception("Permissão insuficiente 0,1,2 | delete");
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' =>  $payloadUsuarioLogado['usuario_uuid'],
        ];

        return $this->hortaRepository->delete($horta, $data) ? true : false;
    }

    private function getCargoSlug(array $payloadUsuarioLogado): string
    {
        return $this->cargoService->findByUuidInternal($payloadUsuarioLogado['cargo_uuid'])->slug;
    } 
}
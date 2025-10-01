<?php

namespace App\Services;

use App\Models\ChaveModel;
use App\Repositories\ChaveRepository;
use Respect\Validation\Validator as v;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Ramsey\Uuid\Uuid;

class ChaveService
{
    protected ChaveRepository $chaveRepository;
    protected HortaService $hortaService;
    protected CargoService $cargoService;

    public function __construct(ChaveRepository $chaveRepository, HortaService $hortaService, CargoService $cargoService)
    {
        $this->chaveRepository = $chaveRepository;
        $this->hortaService = $hortaService;
        $this->cargoService = $cargoService;
    }

    public function findAllWhere(array $payloadUsuarioLogado): Collection
    {
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        
        switch ($cargo) {
            case 'admin_plataforma':
                return $this->chaveRepository->findAllWhere(['excluido' => 0]);
                
            case 'admin_associacao_geral':
                // Busca todas as chaves de hortas da sua associação
                $hortas = $this->hortaService->findAllWhere([], $payloadUsuarioLogado);
                $hortasUuids = $hortas->pluck('uuid')->toArray();
                return $this->chaveRepository->findAllWhere(['excluido' => 0])
                    ->filter(function($chave) use ($hortasUuids) {
                        return in_array($chave->horta_uuid, $hortasUuids);
                    });
                
            case 'admin_horta_geral':
                // Busca apenas chaves da sua horta
                return $this->chaveRepository->findAllWhere([
                    'excluido' => 0,
                    'horta_uuid' => $payloadUsuarioLogado['horta_uuid']
                ]);
                
            default:
                throw new Exception("Permissão insuficiente | findAllWhere");
        }
    }

    public function findByUuid(string $uuid, array $payloadUsuarioLogado): ?ChaveModel
    {
        $chave = $this->chaveRepository->findByUuid($uuid);
        if (!$chave || $chave->excluido) {
            throw new Exception('Chave não encontrada');
        }
        
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        
        switch ($cargo) {
            case 'admin_plataforma':
                return $chave;
                
            case 'admin_associacao_geral':
                // Verifica se a horta da chave pertence à sua associação
                $horta = $this->hortaService->findByUuid($chave->horta_uuid, $payloadUsuarioLogado);
                if ($horta->associacao_vinculada_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não tem permissão para acessar esta chave");
                }
                return $chave;
                
            case 'admin_horta_geral':
                if ($chave->horta_uuid !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você não tem permissão para acessar esta chave");
                }
                return $chave;
                
            default:
                throw new Exception("Permissão insuficiente | findByUuid");
        }
    }

    public function findByHortaUuid(string $hortaUuid, array $payloadUsuarioLogado): Collection
    {
        $horta = $this->hortaService->findByUuid($hortaUuid, $payloadUsuarioLogado); // valida existência e permissão
        
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        
        switch ($cargo) {
            case 'admin_plataforma':
                $chaves = $this->chaveRepository->findByHortaUuid($hortaUuid);
                break;
                
            case 'admin_associacao_geral':
                if ($horta->associacao_vinculada_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não tem permissão para acessar chaves desta horta");
                }
                $chaves = $this->chaveRepository->findByHortaUuid($hortaUuid);
                break;
                
            case 'admin_horta_geral':
                if ($hortaUuid !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você não tem permissão para acessar chaves desta horta");
                }
                $chaves = $this->chaveRepository->findByHortaUuid($hortaUuid);
                break;
                
            default:
                throw new Exception("Permissão insuficiente | findByHortaUuid");
        }
        
        if ($chaves->isEmpty()) {
            throw new Exception('Nenhuma chave encontrada para esta horta');
        }
        return $chaves;
    }

    public function create(array $data, array $payloadUsuarioLogado): ChaveModel
    {
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);

        v::key('codigo', v::stringType()->notEmpty())
          ->key('horta_uuid', v::uuid())
          ->key('observacoes', v::optional(v::stringType()))
          ->key('disponivel', v::optional(v::boolType()))
          ->check($data);

        $horta = $this->hortaService->findByUuid($data['horta_uuid'], $payloadUsuarioLogado);

        switch ($cargo) { 
            case 'admin_plataforma':
                // Pode criar chave para qualquer horta
                break;
                
            case 'admin_associacao_geral':
                // Só pode criar chaves para hortas da sua associação
                if ($horta->associacao_vinculada_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você só pode criar chaves para hortas da sua associação");
                }
                break;
                
            case 'admin_horta_geral':
                // Só pode criar chaves para sua própria horta
                if ($data['horta_uuid'] !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você só pode criar chaves para sua própria horta");
                }
                break;
                
            default:
                throw new Exception("Permissão insuficiente 0,1,2 | create");
        }

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['uuid'] = Uuid::uuid1()->toString();
        $data['usuario_criador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];
        $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];

        return $this->chaveRepository->create($data);
    }

    public function update(string $uuid, array $data, array $payloadUsuarioLogado): ChaveModel
    {
        $chave = $this->chaveRepository->findByUuid($uuid);
        if (!$chave || $chave->excluido) {
            throw new Exception('Chave não encontrada');
        }
        
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        $horta = $this->hortaService->findByUuid($chave->horta_uuid, $payloadUsuarioLogado);
        
        switch ($cargo) { 
            case 'admin_plataforma':
                // Pode editar qualquer chave
                break;
                
            case 'admin_associacao_geral':
                // Só pode editar chaves de hortas da sua associação
                if ($horta->associacao_vinculada_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não tem permissão para editar esta chave");
                }
                break;
                
            case 'admin_horta_geral':
                // Só pode editar chaves da sua horta
                if ($chave->horta_uuid !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você não tem permissão para editar esta chave");
                }
                break;
                
            default:
                throw new Exception("Permissão insuficiente 0,1,2 | update");
        }

        v::key('codigo', v::stringType()->notEmpty(), false)
          ->key('horta_uuid', v::uuid(), false)
          ->key('observacoes', v::optional(v::stringType()), false)
          ->key('disponivel', v::optional(v::boolType()), false)
          ->check($data);

        if (!empty($data['horta_uuid'])) {
            $this->hortaService->findByUuid($data['horta_uuid'], $payloadUsuarioLogado);
        }

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);
        $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];

        return $this->chaveRepository->update($chave, $data);
    }

    public function delete(string $uuid, array $payloadUsuarioLogado): bool
    {
        $chave = $this->chaveRepository->findByUuid($uuid);
        if (!$chave || $chave->excluido) {
            throw new Exception('Chave não encontrada');
        }
        
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        $horta = $this->hortaService->findByUuid($chave->horta_uuid, $payloadUsuarioLogado);
        
        switch ($cargo) { 
            case 'admin_plataforma':
                // Pode deletar qualquer chave
                break;
                
            case 'admin_associacao_geral':
                // Só pode deletar chaves de hortas da sua associação
                if ($horta->associacao_vinculada_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não tem permissão para deletar esta chave");
                }
                break;
                
            case 'admin_horta_geral':
                // Só pode deletar chaves da sua horta
                if ($chave->horta_uuid !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você não tem permissão para deletar esta chave");
                }
                break;
                
            default:
                throw new Exception("Permissão insuficiente 0,1,2 | delete");
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $payloadUsuarioLogado['usuario_uuid']
        ];

        return $this->chaveRepository->delete($chave, $data);
    }

    private function getCargoSlug(array $payloadUsuarioLogado): string
    {
        return $this->cargoService->findByUuidInternal($payloadUsuarioLogado['cargo_uuid'])->slug;
    } 
}
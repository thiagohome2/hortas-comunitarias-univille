<?php
namespace App\Services;

use App\Models\CategoriaFinanceiraModel;
use App\Repositories\CategoriaFinanceiraRepository;
use Respect\Validation\Validator as v;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Ramsey\Uuid\Uuid;

class CategoriaFinanceiraService
{
    protected CategoriaFinanceiraRepository $categoriaFinanceiraRepository;
    protected AssociacaoService $associacaoService;
    protected HortaService $hortaService;
    protected CargoService $cargoService;

    public function __construct(
        CategoriaFinanceiraRepository $categoriaFinanceiraRepository,
        AssociacaoService $associacaoService,
        HortaService $hortaService,
        CargoService $cargoService
    ) {
        $this->categoriaFinanceiraRepository = $categoriaFinanceiraRepository;
        $this->hortaService = $hortaService;
        $this->associacaoService = $associacaoService;
        $this->cargoService = $cargoService;
    }

    public function findAllWhere(array $payloadUsuarioLogado): Collection
    {
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        
        switch ($cargo) {
            case 'admin_plataforma':
                return $this->categoriaFinanceiraRepository->findAllWhere(['excluido' => 0]);
                
            case 'admin_associacao_geral':
                return $this->categoriaFinanceiraRepository->findAllWhere([
                    'excluido' => 0,
                    'associacao_uuid' => $payloadUsuarioLogado['associacao_uuid']
                ]);
                
            case 'admin_horta_geral':
                return $this->categoriaFinanceiraRepository->findAllWhere([
                    'excluido' => 0,
                    'horta_uuid' => $payloadUsuarioLogado['horta_uuid']
                ]);
                
            default:
                throw new Exception("Permissão insuficiente | findAllWhere");
        }
    }

    public function findByUuid(string $uuid, array $payloadUsuarioLogado): ?CategoriaFinanceiraModel
    {
        $categoriaFinanceira = $this->categoriaFinanceiraRepository->findByUuid($uuid);
        if (!$categoriaFinanceira || $categoriaFinanceira->excluido) {
            throw new Exception('Categoria Financeira não encontrada');
        }
        
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        
        switch ($cargo) {
            case 'admin_plataforma':
                return $categoriaFinanceira;
                
            case 'admin_associacao_geral':
                if ($categoriaFinanceira->associacao_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não tem permissão para acessar esta categoria");
                }
                return $categoriaFinanceira;
                
            case 'admin_horta_geral':
                if ($categoriaFinanceira->horta_uuid !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você não tem permissão para acessar esta categoria");
                }
                return $categoriaFinanceira;
                
            default:
                throw new Exception("Permissão insuficiente | findByUuid");
        }
    }

    public function findByHortaUuid(string $hortaUuid, array $payloadUsuarioLogado): Collection
    {
        $horta = $this->hortaService->findByUuid($hortaUuid, $payloadUsuarioLogado);
        if (!$horta || $horta->excluido) {
            throw new Exception('Horta não encontrada');
        }

        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        
        switch ($cargo) {
            case 'admin_plataforma':
                $categoriasDaHorta = $this->categoriaFinanceiraRepository->findByHortaUuid($hortaUuid);
                break;
                
            case 'admin_associacao_geral':
                if ($horta->associacao_vinculada_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não tem permissão para acessar categorias desta horta");
                }
                $categoriasDaHorta = $this->categoriaFinanceiraRepository->findByHortaUuid($hortaUuid);
                break;
                
            case 'admin_horta_geral':
                if ($hortaUuid !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você não tem permissão para acessar categorias desta horta");
                }
                $categoriasDaHorta = $this->categoriaFinanceiraRepository->findByHortaUuid($hortaUuid);
                break;
                
            default:
                throw new Exception("Permissão insuficiente | findByHortaUuid");
        }
        
        if ($categoriasDaHorta->isEmpty()) {
            throw new Exception('Categorias da horta não encontradas');
        }
        return $categoriasDaHorta;
    }
    
    public function findByAssociacaoUuid(string $associacaoUuid, array $payloadUsuarioLogado): Collection
    {
        $associacao = $this->associacaoService->findByUuid($associacaoUuid, $payloadUsuarioLogado);
        if (!$associacao || $associacao->excluido) {
            throw new Exception('Associação não encontrada');
        }

        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        
        switch ($cargo) {
            case 'admin_plataforma':
                $categoriasDaAssociacao = $this->categoriaFinanceiraRepository->findByAssociacaoUuid($associacaoUuid);
                break;
                
            case 'admin_associacao_geral':
                if ($associacaoUuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não tem permissão para acessar categorias desta associação");
                }
                $categoriasDaAssociacao = $this->categoriaFinanceiraRepository->findByAssociacaoUuid($associacaoUuid);
                break;
                
            default:
                throw new Exception("Permissão insuficiente | findByAssociacaoUuid");
        }
        
        if ($categoriasDaAssociacao->isEmpty()) {
            throw new Exception('Categorias da associação não encontradas');
        }
        return $categoriasDaAssociacao;
    }

    public function create(array $data, array $payloadUsuarioLogado): CategoriaFinanceiraModel
    {
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);

        v::key('nome', v::stringType()->notEmpty()->length(1, 100))
            ->key('descricao', v::optional(v::stringType()))
            ->key('tipo', v::intType()->in([1, 2, 3]))
            ->key('cor', v::optional(v::stringType()->regex('/^#[0-9A-Fa-f]{6}$/')))
            ->key('icone', v::optional(v::stringType()->length(1, 50)))
            ->key('associacao_uuid', v::uuid(), false)
            ->key('horta_uuid', v::uuid(), false)
            ->check($data);

        if (empty($data['associacao_uuid']) && empty($data['horta_uuid'])) {
            throw new Exception("É obrigatório informar associacao_uuid OU horta_uuid.");
        }
        if (!empty($data['associacao_uuid']) && !empty($data['horta_uuid'])) {
            throw new Exception("Não é permitido informar associacao_uuid E horta_uuid ao mesmo tempo.");
        }

        switch ($cargo) { 
            case 'admin_plataforma':
                // Pode criar para qualquer associação ou horta
                break;
                
            case 'admin_associacao_geral':
                // Só pode criar para sua própria associação
                if (!empty($data['associacao_uuid']) && $data['associacao_uuid'] !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você só pode criar categorias para sua própria associação");
                }
                // Não pode criar para hortas
                if (!empty($data['horta_uuid'])) {
                    throw new Exception("Você não tem permissão para criar categorias para hortas");
                }
                break;
                
            case 'admin_horta_geral':
                // Só pode criar para sua própria horta
                if (!empty($data['horta_uuid']) && $data['horta_uuid'] !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você só pode criar categorias para sua própria horta");
                }
                // Não pode criar para associações
                if (!empty($data['associacao_uuid'])) {
                    throw new Exception("Você não tem permissão para criar categorias para associações");
                }
                break;
                
            default:
                throw new Exception("Permissão insuficiente 0,1,2 | create");
        }

        if (!empty($data['associacao_uuid'])) {
            $this->associacaoService->findByUuid($data['associacao_uuid'], $payloadUsuarioLogado);
        }
        if (!empty($data['horta_uuid'])) {
            $this->hortaService->findByUuid($data['horta_uuid'], $payloadUsuarioLogado);
        }

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['uuid'] = Uuid::uuid1()->toString();
        $data['usuario_criador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];
        $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];

        return $this->categoriaFinanceiraRepository->create($data);
    }

    public function update(string $uuid, array $data, array $payloadUsuarioLogado): CategoriaFinanceiraModel
    {
        $categoriaFinanceira = $this->categoriaFinanceiraRepository->findByUuid($uuid);
        if (!$categoriaFinanceira || $categoriaFinanceira->excluido) {
            throw new Exception('Categoria Financeira não encontrada');
        }
        
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        
        switch ($cargo) { 
            case 'admin_plataforma':
                // Pode editar qualquer categoria
                break;
                
            case 'admin_associacao_geral':
                // Só pode editar categorias da sua associação
                if ($categoriaFinanceira->associacao_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não tem permissão para editar esta categoria");
                }
                break;
                
            case 'admin_horta_geral':
                // Só pode editar categorias da sua horta
                if ($categoriaFinanceira->horta_uuid !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você não tem permissão para editar esta categoria");
                }
                break;
                
            default:
                throw new Exception("Permissão insuficiente 0,1,2 | update");
        }

        v::key('nome', v::stringType()->notEmpty()->length(1, 100), false)
            ->key('descricao', v::optional(v::stringType()), false)
            ->key('tipo', v::intType()->in([1, 2, 3]), false)
            ->key('cor', v::optional(v::stringType()->regex('/^#[0-9A-Fa-f]{6}$/')), false)
            ->key('icone', v::optional(v::stringType()->length(1, 50)), false)
            ->key('associacao_uuid', v::uuid(), false)
            ->key('horta_uuid', v::uuid(), false)
            ->check($data);

        if (!empty($data['associacao_uuid'])) {
            $this->associacaoService->findByUuid($data['associacao_uuid'], $payloadUsuarioLogado);
        }
        if (!empty($data['horta_uuid'])) {
            $this->hortaService->findByUuid($data['horta_uuid'], $payloadUsuarioLogado);
        }

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];

        return $this->categoriaFinanceiraRepository->update($categoriaFinanceira, $data);
    }

    public function delete(string $uuid, array $payloadUsuarioLogado): bool
    {
        $categoriaFinanceira = $this->categoriaFinanceiraRepository->findByUuid($uuid);
        if (!$categoriaFinanceira || $categoriaFinanceira->excluido) {
            throw new Exception('Categoria Financeira não encontrada');
        }
        
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        
        switch ($cargo) { 
            case 'admin_plataforma':
                // Pode deletar qualquer categoria
                break;
                
            case 'admin_associacao_geral':
                // Só pode deletar categorias da sua associação
                if ($categoriaFinanceira->associacao_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não tem permissão para deletar esta categoria");
                }
                break;
                
            case 'admin_horta_geral':
                // Só pode deletar categorias da sua horta
                if ($categoriaFinanceira->horta_uuid !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você não tem permissão para deletar esta categoria");
                }
                break;
                
            default:
                throw new Exception("Permissão insuficiente 0,1,2 | delete");
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $payloadUsuarioLogado['usuario_uuid'],
        ];

        return $this->categoriaFinanceiraRepository->delete($categoriaFinanceira, $data);
    }

    private function getCargoSlug(array $payloadUsuarioLogado): string
    {
        return $this->cargoService->findByUuidInternal($payloadUsuarioLogado['cargo_uuid'])->slug;
    } 
}
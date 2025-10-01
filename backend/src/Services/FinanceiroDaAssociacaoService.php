<?php
namespace App\Services;

use App\Models\FinanceiroDaAssociacaoModel;
use App\Repositories\FinanceiroDaAssociacaoRepository;
use Respect\Validation\Validator as v;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Ramsey\Uuid\Uuid;

class FinanceiroDaAssociacaoService
{
    protected $financeiroDaAssociacaoRepository;
    protected CategoriaFinanceiraService $categoriaFinanceiraService;
    protected AssociacaoService $associacaoService;
    protected MensalidadeDaAssociacaoService $mensalidadeDaAssociacaoService;
    protected CargoService $cargoService;

    public function __construct(
        FinanceiroDaAssociacaoRepository $financeiroDaAssociacaoRepository,
        CategoriaFinanceiraService $categoriaFinanceiraService, 
        AssociacaoService $associacaoService,
        MensalidadeDaAssociacaoService $mensalidadeDaAssociacaoService,
        CargoService $cargoService
    ){
        $this->financeiroDaAssociacaoRepository = $financeiroDaAssociacaoRepository;
        $this->categoriaFinanceiraService = $categoriaFinanceiraService;
        $this->associacaoService = $associacaoService;
        $this->mensalidadeDaAssociacaoService = $mensalidadeDaAssociacaoService;
        $this->cargoService = $cargoService;
    }

    public function findAllWhere(array $payloadUsuarioLogado): Collection {
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        
        switch ($cargo) {
            case 'admin_plataforma':
                return $this->financeiroDaAssociacaoRepository->findAllWhere(['excluido' => 0]);
                
            case 'admin_associacao_geral':
            case 'admin_horta_geral':
            case 'canteirista':
            case 'dependente':
                return $this->financeiroDaAssociacaoRepository->findAllWhere([
                    'excluido' => 0,
                    'associacao_uuid' => $payloadUsuarioLogado['associacao_uuid']
                ]);
                
            default:
                throw new Exception("Permissão insuficiente | findAllWhere");
        }
    }

    public function findByUuid(string $uuid, array $payloadUsuarioLogado): ?FinanceiroDaAssociacaoModel {
        $financeiroDaAssociacao = $this->financeiroDaAssociacaoRepository->findByUuid($uuid);
        if(!$financeiroDaAssociacao || $financeiroDaAssociacao->excluido){
            throw new Exception('Financeiro da Associação não encontrado');
        }
        
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        
        switch ($cargo) {
            case 'admin_plataforma':
                return $financeiroDaAssociacao;
                
            case 'admin_associacao_geral':
            case 'admin_horta_geral':
            case 'canteirista':
            case 'dependente':
                if ($financeiroDaAssociacao->associacao_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não tem permissão para acessar este lançamento");
                }
                return $financeiroDaAssociacao;
                
            default:
                throw new Exception("Permissão insuficiente | findByUuid");
        }
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
                $financeirosDaAssociacao = $this->financeiroDaAssociacaoRepository->findByAssociacaoUuid($associacaoUuid);
                break;
                
            case 'admin_associacao_geral':
            case 'admin_horta_geral':
            case 'canteirista':
            case 'dependente':
                if ($associacaoUuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não tem permissão para acessar lançamentos desta associação");
                }
                $financeirosDaAssociacao = $this->financeiroDaAssociacaoRepository->findByAssociacaoUuid($associacaoUuid);
                break;
                
            default:
                throw new Exception("Permissão insuficiente | findByAssociacaoUuid");
        }
        
        if ($financeirosDaAssociacao->isEmpty()) {
            throw new Exception('Financeiros da associação não encontrados');
        }
        return $financeirosDaAssociacao;
    }

    public function create(array $data, array $payloadUsuarioLogado): FinanceiroDaAssociacaoModel {
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);

        switch ($cargo) { 
            case 'admin_plataforma':
                // Pode criar para qualquer associação
                break;
                
            case 'admin_associacao_geral':
                // Só pode criar para sua própria associação
                if (!empty($data['associacao_uuid']) && $data['associacao_uuid'] !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você só pode criar lançamentos para sua própria associação");
                }
                break;
                
            default:
                throw new Exception("Permissão insuficiente 0,1 | create");
        }
        
        v::key('valor_em_centavos', v::intType()->min(0))
        ->key('descricao_do_lancamento', v::stringType()->notEmpty())
        ->key('categoria_uuid', v::optional(v::uuid()))
        ->key('url_anexo', v::optional(v::url()))
        ->key('data_do_lancamento', v::date('Y-m-d'))
        ->key('associacao_uuid', v::uuid())
        ->key('mensalidade_uuid', v::optional(v::uuid()))
        ->check($data);

        if (!empty($data['associacao_uuid'])) {
            $this->associacaoService->findByUuid($data['associacao_uuid'], $payloadUsuarioLogado);
        }
        if (!empty($data['categoria_uuid'])) {
            $this->categoriaFinanceiraService->findByUuid($data['categoria_uuid']);
        }
        if (!empty($data['mensalidade_uuid'])) {
            $this->mensalidadeDaAssociacaoService->findByUuid($data['mensalidade_uuid'], $payloadUsuarioLogado);
        }

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['uuid'] = Uuid::uuid1()->toString();
        $data['usuario_criador_uuid'] =  $payloadUsuarioLogado['usuario_uuid'];
        $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];

        return $this->financeiroDaAssociacaoRepository->create($data);
    }

    public function update(string $uuid, array $data, array $payloadUsuarioLogado): FinanceiroDaAssociacaoModel {
        $financeiroDaAssociacao = $this->financeiroDaAssociacaoRepository->findByUuid($uuid);
        if(!$financeiroDaAssociacao || $financeiroDaAssociacao->excluido){
            throw new Exception('Financeiro da Associação não encontrado');
        }
        
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        
        switch ($cargo) { 
            case 'admin_plataforma':
                // Pode editar qualquer lançamento
                break;
                
            case 'admin_associacao_geral':
                // Só pode editar lançamentos da sua associação
                if ($financeiroDaAssociacao->associacao_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não tem permissão para editar este lançamento");
                }
                break;
                
            default:
                throw new Exception("Permissão insuficiente 0,1 | update");
        }

        v::key('valor_em_centavos', v::intType()->min(0), false)
        ->key('descricao_do_lancamento', v::stringType()->notEmpty(), false)
        ->key('categoria_uuid', v::optional(v::uuid()), false)
        ->key('url_anexo', v::optional(v::url()), false)
        ->key('data_do_lancamento', v::date('Y-m-d'), false)
        ->key('associacao_uuid', v::uuid(), false)
        ->key('mensalidade_uuid', v::optional(v::uuid()), false)
        ->check($data);

        if (!empty($data['associacao_uuid'])) {
            $this->associacaoService->findByUuid($data['associacao_uuid'], $payloadUsuarioLogado);
        }
        if (!empty($data['categoria_uuid'])) {
            $this->categoriaFinanceiraService->findByUuid($data['categoria_uuid']);
        }
        if (!empty($data['mensalidade_uuid'])) {
            $this->mensalidadeDaAssociacaoService->findByUuid($data['mensalidade_uuid'], $payloadUsuarioLogado);
        }

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];

        return $this->financeiroDaAssociacaoRepository->update($financeiroDaAssociacao, $data);
    }

    public function delete(string $uuid, array $payloadUsuarioLogado): bool {
        $financeiroDaAssociacao = $this->financeiroDaAssociacaoRepository->findByUuid($uuid);
        if (!$financeiroDaAssociacao || $financeiroDaAssociacao->excluido) {
            throw new Exception('Financeiro da Associação não encontrado');
        }
        
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        
        switch ($cargo) { 
            case 'admin_plataforma':
                // Pode deletar qualquer lançamento
                break;
                
            case 'admin_associacao_geral':
                // Só pode deletar lançamentos da sua associação
                if ($financeiroDaAssociacao->associacao_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não tem permissão para deletar este lançamento");
                }
                break;
                
            default:
                throw new Exception("Permissão insuficiente 0,1 | delete");
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $payloadUsuarioLogado['usuario_uuid'],
        ];

        return $this->financeiroDaAssociacaoRepository->delete($financeiroDaAssociacao, $data);
    }

    private function getCargoSlug(array $payloadUsuarioLogado): string
    {
        return $this->cargoService->findByUuidInternal($payloadUsuarioLogado['cargo_uuid'])->slug;
    } 
}
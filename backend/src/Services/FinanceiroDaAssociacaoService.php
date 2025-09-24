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


    public function __construct(FinanceiroDaAssociacaoRepository $financeiroDaAssociacaoRepository,
    CategoriaFinanceiraService $categoriaFinanceiraService, AssociacaoService $associacaoService, MensalidadeDaAssociacaoService $mensalidadeDaAssociacaoService){
        $this->financeiroDaAssociacaoRepository = $financeiroDaAssociacaoRepository;
        $this->categoriaFinanceiraService = $categoriaFinanceiraService;
        $this->associacaoService = $associacaoService;
        $this->mensalidadeDaAssociacaoService = $mensalidadeDaAssociacaoService;
    }

    public function findAllWhere(): Collection {
        return $this->financeiroDaAssociacaoRepository->findAllWhere(['excluido' => 0]);
    }

    public function findByUuid(string $uuid): ?FinanceiroDaAssociacaoModel {
        $financeiroDaAssociacao = $this->financeiroDaAssociacaoRepository->findByUuid($uuid);
        if(!$financeiroDaAssociacao || $financeiroDaAssociacao->excluido){
            throw new Exception('Financeiro da Associação não encontrado');
        }
        return $financeiroDaAssociacao;
    }

    public function create(array $data, string $uuidUsuarioLogado): FinanceiroDaAssociacaoModel {
        v::key('valor_em_centavos', v::intType()->min(0))
        ->key('descricao_do_lancamento', v::stringType()->notEmpty())
        ->key('categoria_uuid', v::optional(v::uuid()))
        ->key('url_anexo', v::optional(v::url()))
        ->key('data_do_lancamento', v::date('Y-m-d'))
        ->key('associacao_uuid', v::uuid())
        ->key('mensalidade_uuid', v::optional(v::uuid()))
        ->check($data);

        if (!empty($data['associacao_uuid'])) {
            $this->associacaoService->findByUuid($data['associacao_uuid']);
        }
        if (!empty($data['categoria_uuid'])) {
            $this->categoriaFinanceiraService->findByUuid($data['categoria_uuid']);
        }
        if (!empty($data['mensalidade_uuid'])) {
            $this->mensalidadeDaAssociacaoService->findByUuid($data['mensalidade_uuid']);
        }

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['uuid'] = Uuid::uuid1()->toString();
        $data['usuario_criador_uuid'] = $uuidUsuarioLogado;
        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        return $this->financeiroDaAssociacaoRepository->create($data);
    }

    public function update(string $uuid, array $data, string $uuidUsuarioLogado): FinanceiroDaAssociacaoModel {
        $financeiroDaAssociacao = $this->financeiroDaAssociacaoRepository->findByUuid($uuid);
        if(!$financeiroDaAssociacao || $financeiroDaAssociacao->excluido){
            throw new Exception('Financeiro da Associação não encontrado');
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
            $this->associacaoService->findByUuid($data['associacao_uuid']);
        }
        if (!empty($data['categoria_uuid'])) {
            $this->categoriaFinanceiraService->findByUuid($data['categoria_uuid']);
        }
        if (!empty($data['mensalidade_uuid'])) {
            $this->mensalidadeDaAssociacaoService->findByUuid($data['mensalidade_uuid']);
        }

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        return $this->financeiroDaAssociacaoRepository->update($financeiroDaAssociacao, $data);
    }

    public function delete(string $uuid, string $uuidUsuarioLogado): bool {
        $financeiroDaAssociacao = $this->financeiroDaAssociacaoRepository->findByUuid($uuid);
        if (!$financeiroDaAssociacao || $financeiroDaAssociacao->excluido) {
            throw new Exception('Financeiro da Associação não encontrado');
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $uuidUsuarioLogado,
        ];

        return $this->financeiroDaAssociacaoRepository->delete($financeiroDaAssociacao, $data);
    }
}

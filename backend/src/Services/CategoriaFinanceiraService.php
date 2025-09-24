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

    public function __construct(CategoriaFinanceiraRepository $categoriaFinanceiraRepository,
    AssociacaoService $associacaoService, HortaService $hortaService){
        $this->categoriaFinanceiraRepository = $categoriaFinanceiraRepository;
        $this->hortaService = $hortaService;
        $this->associacaoService = $associacaoService;
    }

    public function findAllWhere(): Collection {
        return $this->categoriaFinanceiraRepository->findAllWhere(['excluido' => 0]);
    }

    public function findByUuid(string $uuid): ?CategoriaFinanceiraModel {
        $categoriaFinanceira = $this->categoriaFinanceiraRepository->findByUuid($uuid);
        if(!$categoriaFinanceira || $categoriaFinanceira->excluido){
            throw new Exception('Categoria Financeira não encontrado');
        }
        return $categoriaFinanceira;
    }

    public function create(array $data, string $uuidUsuarioLogado): CategoriaFinanceiraModel {
        v::key('nome', v::stringType()->notEmpty()->length(1, 100))
        ->key('descricao', v::optional(v::stringType()))
        ->key('tipo', v::intType()->in([1, 2, 3]))
        ->key('cor', v::optional(v::stringType()->regex('/^#[0-9A-Fa-f]{6}$/')))
        ->key('icone', v::optional(v::stringType()->length(1, 50)))
        ->key('associacao_uuid', v::uuid(), false)
        ->key('horta_uuid', v::uuid(), false)
        ->check($data);

        if (empty($data['associacao_uuid']) && empty($data['horta_uuid'])) {
            throw new \Exception("É obrigatório informar associacao_uuid OU horta_uuid.");
        }
        if (!empty($data['associacao_uuid']) && !empty($data['horta_uuid'])) {
            throw new \Exception("Não é permitido informar associacao_uuid E horta_uuid ao mesmo tempo.");
        }

        if (!empty($data['associacao_uuid'])){
            $this->associacaoService->findByUuid($data['associacao_uuid']);
        }

        if (!empty($data['horta_uuid'])) {
            $this->hortaService->findByUuid($data['horta_uuid']);
        }

        echo $data['horta_uuid'];

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['uuid'] = Uuid::uuid1()->toString();
        $data['usuario_criador_uuid'] = $uuidUsuarioLogado;
        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        return $this->categoriaFinanceiraRepository->create($data);
    }

    public function update(string $uuid, array $data, string $uuidUsuarioLogado): CategoriaFinanceiraModel {
        $categoriaFinanceira = $this->categoriaFinanceiraRepository->findByUuid($uuid);
        if(!$categoriaFinanceira || $categoriaFinanceira->excluido){
            throw new Exception('Categoria Financeira não encontrado');
        }

        v::key('nome', v::stringType()->notEmpty()->length(1, 100), false)
        ->key('descricao', v::optional(v::stringType()), false)
        ->key('tipo', v::intType()->in([1, 2, 3]), false)
        ->key('cor', v::optional(v::stringType()->regex('/^#[0-9A-Fa-f]{6}$/')), false)
        ->key('icone', v::optional(v::stringType()->length(1, 50)), false)
        ->key('associacao_uuid', v::uuid(), false)
        ->key('horta_uuid', v::uuid(), false)
        ->check($data);

        if (!empty($data['associacao_uuid'])){
            $this->associacaoService->findByUuid($data['associacao_uuid']);
        }

        if (!empty($data['horta_uuid'])) {
            $this->hortaService->findByUuid($data['horta_uuid']);
        }

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        return $this->categoriaFinanceiraRepository->update($categoriaFinanceira, $data);
    }

    public function delete(string $uuid, string $uuidUsuarioLogado): bool {
        $categoriaFinanceira = $this->categoriaFinanceiraRepository->findByUuid($uuid);
        if (!$categoriaFinanceira || $categoriaFinanceira->excluido) {
            throw new Exception('Categoria Financeira não encontrado');
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $uuidUsuarioLogado,
        ];

        return $this->categoriaFinanceiraRepository->delete($categoriaFinanceira, $data);
    }
}

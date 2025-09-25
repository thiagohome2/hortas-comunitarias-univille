<?php
namespace App\Services;

use App\Models\FinanceiroDaHortaModel;
use App\Repositories\FinanceiroDaHortaRepository;
use Respect\Validation\Validator as v;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Ramsey\Uuid\Uuid;

class FinanceiroDaHortaService
{
    protected FinanceiroDaHortaRepository $financeiroDaHortaRepository;
    protected CategoriaFinanceiraService $categoriaFinanceiraService;
    protected HortaService $hortaService;

    public function __construct(FinanceiroDaHortaRepository $financeiroDaHortaRepository,
    CategoriaFinanceiraService $categoriaFinanceiraService, HortaService $hortaService){
        $this->financeiroDaHortaRepository = $financeiroDaHortaRepository;
        $this->categoriaFinanceiraService = $categoriaFinanceiraService;
        $this->hortaService = $hortaService;
    }

    public function findAllWhere(): Collection {
        return $this->financeiroDaHortaRepository->findAllWhere(['excluido' => 0]);
    }

    public function findByUuid(string $uuid): ?FinanceiroDaHortaModel {
        $financeiroDaHorta = $this->financeiroDaHortaRepository->findByUuid($uuid);
        if(!$financeiroDaHorta || $financeiroDaHorta->excluido){
            throw new Exception('Financeiro da Horta não encontrado');
        }
        return $financeiroDaHorta;
    }

    public function findByHortaUuid(string $hortaUuid): Collection
    {
        $horta = $this->hortaService->findByUuid($hortaUuid);
        if (!$horta || $horta->excluido) {
            throw new Exception('Horta não encontrado');
        }
        $financeirosDaHorta = $this->financeiroDaHortaRepository->findByHortaUuid($hortaUuid);
        if ($financeirosDaHorta->isEmpty()) {
            throw new Exception('Financeiros da horta não encontrados');
        }
        return $financeirosDaHorta;
    }

    public function create(array $data, string $uuidUsuarioLogado): FinanceiroDaHortaModel {
        v::key('valor_em_centavos', v::intType()->min(0))
        ->key('descricao_do_lancamento', v::stringType()->notEmpty())
        ->key('categoria_uuid', v::optional(v::uuid()))
        ->key('url_anexo', v::optional(v::url()))
        ->key('data_do_lancamento', v::date('Y-m-d'))
        ->key('horta_uuid', v::uuid())
        ->check($data);

        if (!empty($data['horta_uuid'])) {
            $this->hortaService->findByUuid($data['horta_uuid']);
        }
        if (!empty($data['categoria_uuid'])) {
            $this->categoriaFinanceiraService->findByUuid($data['categoria_uuid']);
        }

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['uuid'] = Uuid::uuid1()->toString();
        $data['usuario_criador_uuid'] = $uuidUsuarioLogado;
        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        return $this->financeiroDaHortaRepository->create($data);
    }

    public function update(string $uuid, array $data, string $uuidUsuarioLogado): FinanceiroDaHortaModel {
        $financeiroDaHorta = $this->financeiroDaHortaRepository->findByUuid($uuid);
        if(!$financeiroDaHorta || $financeiroDaHorta->excluido){
            throw new Exception('Financeiro da Horta não encontrado');
        }

        v::key('valor_em_centavos', v::intType()->min(0), false)
        ->key('descricao_do_lancamento', v::stringType()->notEmpty(), false)
        ->key('categoria_uuid', v::optional(v::uuid()), false)
        ->key('url_anexo', v::optional(v::url()), false)
        ->key('data_do_lancamento', v::date('Y-m-d'), false)
        ->key('horta_uuid', v::uuid(), false)
        ->check($data);

        if (!empty($data['horta_uuid'])) {
            $this->hortaService->findByUuid($data['horta_uuid']);
        }
        if (!empty($data['categoria_uuid'])) {
            $this->categoriaFinanceiraService->findByUuid($data['categoria_uuid']);
        }

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        return $this->financeiroDaHortaRepository->update($financeiroDaHorta, $data);
    }

    public function delete(string $uuid, string $uuidUsuarioLogado): bool {
        $financeiroDaHorta = $this->financeiroDaHortaRepository->findByUuid($uuid);
        if (!$financeiroDaHorta || $financeiroDaHorta->excluido) {
            throw new Exception('Financeiro da Horta não encontrado');
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $uuidUsuarioLogado,
        ];

        return $this->financeiroDaHortaRepository->delete($financeiroDaHorta, $data);
    }
}

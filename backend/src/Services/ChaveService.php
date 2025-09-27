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

    public function __construct(ChaveRepository $chaveRepository, HortaService $hortaService)
    {
        $this->chaveRepository = $chaveRepository;
        $this->hortaService = $hortaService;
    }

    public function findAllWhere(): Collection
    {
        return $this->chaveRepository->findAllWhere(['excluido' => 0]);
    }

    public function findByUuid(string $uuid): ?ChaveModel
    {
        $chave = $this->chaveRepository->findByUuid($uuid);
        if (!$chave || $chave->excluido) {
            throw new Exception('Chave não encontrada');
        }
        return $chave;
    }

    public function findByHortaUuid(string $hortaUuid): Collection
    {
        $this->hortaService->findByUuid($hortaUuid); // valida existência
        $chaves = $this->chaveRepository->findByHortaUuid($hortaUuid);
        if ($chaves->isEmpty()) {
            throw new Exception('Nenhuma chave encontrada para esta horta');
        }
        return $chaves;
    }

    public function create(array $data, string $uuidUsuarioLogado): ChaveModel
    {
        v::key('codigo', v::stringType()->notEmpty())
          ->key('horta_uuid', v::uuid())
          ->key('observacoes', v::optional(v::stringType()))
          ->key('disponivel', v::optional(v::boolType()))
          ->check($data);

        $this->hortaService->findByUuid($data['horta_uuid']);

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['uuid'] = Uuid::uuid1()->toString();
        $data['usuario_criador_uuid'] = $uuidUsuarioLogado;
        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        return $this->chaveRepository->create($data);
    }

    public function update(string $uuid, array $data, string $uuidUsuarioLogado): ChaveModel
    {
        $chave = $this->chaveRepository->findByUuid($uuid);
        if (!$chave || $chave->excluido) {
            throw new Exception('Chave não encontrada');
        }

        v::key('codigo', v::stringType()->notEmpty(), false)
          ->key('horta_uuid', v::uuid(), false)
          ->key('observacoes', v::optional(v::stringType()), false)
          ->key('disponivel', v::optional(v::boolType()), false)
          ->check($data);

        if (!empty($data['horta_uuid'])) {
            $this->hortaService->findByUuid($data['horta_uuid']);
        }

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);
        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        return $this->chaveRepository->update($chave, $data);
    }

    public function delete(string $uuid, string $uuidUsuarioLogado): bool
    {
        $chave = $this->chaveRepository->findByUuid($uuid);
        if (!$chave || $chave->excluido) {
            throw new Exception('Chave não encontrada');
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $uuidUsuarioLogado
        ];

        return $this->chaveRepository->delete($chave, $data);
    }
}

<?php

namespace App\Repositories;

use App\Models\MensalidadeDaAssociacaoModel;
use Illuminate\Database\Eloquent\Collection;

class MensalidadeDaAssociacaoRepository
{
    protected MensalidadeDaAssociacaoModel $mensalidadeDaAssociacaoModel;

    public function __construct(MensalidadeDaAssociacaoModel $mensalidadeDaAssociacaoModel) {
        $this->mensalidadeDaAssociacaoModel = $mensalidadeDaAssociacaoModel;
    }

    public function findAllWhere(array $conditions): Collection
    {
        return $this->mensalidadeDaAssociacaoModel->where($conditions)->get();
    }

    public function findByUuid(string $uuid): ?MensalidadeDaAssociacaoModel
    {
        return $this->mensalidadeDaAssociacaoModel->find($uuid);
    }

    public function findByUsuarioUuid(string $usuarioUuid): Collection
    {
        $registros = $this->mensalidadeDaAssociacaoModel
        ->where("usuario_uuid", $usuarioUuid)
        ->where("excluido", 0)
        ->get();

        return $registros;
    }

    public function findByAssociacaoUuid(string $associacaoUuid): Collection
    {
        $registros = $this->mensalidadeDaAssociacaoModel
        ->where("associacao_uuid", $associacaoUuid)
        ->where("excluido", 0)
        ->get();

        return $registros;
    }

    public function create(array $data): MensalidadeDaAssociacaoModel
    {
        return $this->mensalidadeDaAssociacaoModel->create($data);
    }

    public function update(MensalidadeDaAssociacaoModel $mensalidadeDaAssociacao, array $data): ?MensalidadeDaAssociacaoModel
    {
        $mensalidadeDaAssociacao->update($data);
        return $mensalidadeDaAssociacao;
    }

    public function delete(MensalidadeDaAssociacaoModel $mensalidadeDaAssociacao, array $data): bool
    {
        $mensalidadeDaAssociacao->fill($data);
        return $mensalidadeDaAssociacao->save();
    }
}

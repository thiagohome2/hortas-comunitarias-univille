<?php

namespace App\Repositories;

use App\Models\FilaDeUsuarioModel;
use Illuminate\Database\Eloquent\Collection;

class FilaDeUsuarioRepository
{
    protected FilaDeUsuarioModel $filaDeUsuarioModel;

    public function __construct(FilaDeUsuarioModel $filaDeUsuarioModel) {
        $this->filaDeUsuarioModel = $filaDeUsuarioModel;
    }

    public function findAllWhere(array $conditions = []): Collection
    {
        return $this->filaDeUsuarioModel->where($conditions)->get();
    }

    public function findByUuid(string $uuid): ?FilaDeUsuarioModel
    {
        return $this->filaDeUsuarioModel->find($uuid);
    }

    public function findByHortaUuid(string $hortaUuid): Collection
    {
        return $this->filaDeUsuarioModel
            ->where("horta_uuid", $hortaUuid)
            ->where('excluido', 0)
            ->get();
    }

    public function findByUsuarioUuid(string $usuarioUuid): Collection
    {
        return $this->filaDeUsuarioModel
            ->where("usuario_uuid", $usuarioUuid)
            ->where('excluido', 0)
            ->get();
    }

    public function create(array $data): FilaDeUsuarioModel
    {
        return $this->filaDeUsuarioModel->create($data);
    }

    public function update(FilaDeUsuarioModel $fila, array $data): ?FilaDeUsuarioModel
    {
        $fila->update($data);
        return $fila;
    }

    public function delete(FilaDeUsuarioModel $fila, array $data): bool
    {
        $fila->fill($data);
        return $fila->save();
    }
}

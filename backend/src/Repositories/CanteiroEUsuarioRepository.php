<?php

namespace App\Repositories;

use App\Models\CanteiroEUsuarioModel;
use Illuminate\Database\Eloquent\Collection;

class CanteiroEUsuarioRepository
{
    protected CanteiroEUsuarioModel $canteiroEUsuarioModel;

    public function __construct(CanteiroEUsuarioModel $canteiroEUsuarioModel) {
        $this->canteiroEUsuarioModel = $canteiroEUsuarioModel;
    }

    public function findAllWhere(): Collection
    {
        return $this->canteiroEUsuarioModel->where("excluido", 0)->get();
    }

    public function findByUuid(string $uuid): ?CanteiroEUsuarioModel
    {
        return $this->canteiroEUsuarioModel->find($uuid);
    }

    public function create(array $data): CanteiroEUsuarioModel
    {
        return $this->canteiroEUsuarioModel->create($data);
    }

    public function update(CanteiroEUsuarioModel $canteiroEUsuario, array $data): ?CanteiroEUsuarioModel
    {
        $canteiroEUsuario->update($data);
        return $canteiroEUsuario;
    }

    public function delete(CanteiroEUsuarioModel $canteiroEUsuario, array $data): bool
    {
        $canteiroEUsuario->fill($data);
        return $canteiroEUsuario->save();
    }
}

<?php

namespace App\Repositories;

use App\Models\UsuarioModel;

class UsuarioRepository
{
    protected $model;

    public function __construct(UsuarioModel $usuario)
    {
        $this->model = $usuario;
    }

    public function findByUuid(string $uuid): ?UsuarioModel
    {
        return $this->model->find($uuid);
    }

    public function findAll()
    {
        return $this->model->all();
    }

    public function create(array $data): UsuarioModel
    {
        return $this->model->create($data);
    }

    public function update(UsuarioModel $usuario, array $data): UsuarioModel
    {
        $usuario->update($data);
        return $usuario;
    }

    public function delete(UsuarioModel $usuario): bool {
        $usuario->excluido = 1;
        return $usuario->save();
    }

    public function findAllWhere(array $conditions)
    {
        return $this->model->where($conditions)->get();
    }

}

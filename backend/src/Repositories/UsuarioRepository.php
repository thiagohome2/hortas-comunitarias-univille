<?php

namespace App\Repositories;

use App\Models\UsuarioModel;
use Illuminate\Database\Eloquent\Collection;

class UsuarioRepository
{
    protected $usuarioModel;

    public function __construct(UsuarioModel $usuarioModel)
    {
        $this->usuarioModel = $usuarioModel;
    }

    public function findAllWhere(array $conditions): Collection
    {
        return $this->usuarioModel->where($conditions)->get();
    }

    public function findByUuid(string $uuid): ?UsuarioModel
    {
        return $this->usuarioModel->find($uuid);
    }

    public function findByCpf(string $cpf): ?UsuarioModel
    {
        return $this->usuarioModel->where('cpf', $cpf)->first();
    }
    public function findByEmail(string $email): ?UsuarioModel
    {
        return $this->usuarioModel->where('email', $email)->first();
    }
    
    public function create(array $data): UsuarioModel
    {
        return $this->usuarioModel->create($data);
    }
    
    public function update(UsuarioModel $usuario, array $data): UsuarioModel
    {
        $usuario->update($data);
        return $usuario;
    }

    public function delete(UsuarioModel $usuario, array $data): bool
    {
        $usuario->fill($data);
        return $usuario->save();
    }
}

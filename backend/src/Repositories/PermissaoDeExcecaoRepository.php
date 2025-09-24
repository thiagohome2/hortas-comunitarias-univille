<?php

namespace App\Repositories;

use App\Models\PermissaoDeExcecaoModel;
use Illuminate\Database\Eloquent\Collection;

class PermissaoDeExcecaoRepository
{
    protected PermissaoDeExcecaoModel $permissaoDeExcecaoModel;

    public function __construct(PermissaoDeExcecaoModel $permissaoDeExcecaoModel) {
        $this->permissaoDeExcecaoModel = $permissaoDeExcecaoModel;
    }

    public function findAllWhere(array $conditions): Collection
    {
        return $this->permissaoDeExcecaoModel->where($conditions)->get();
    }

    public function findByUuid(string $uuid): ?PermissaoDeExcecaoModel
    {
        return $this->permissaoDeExcecaoModel->find($uuid);
    }
    public function findByUserUuid(string $usuarioUuid): Collection
    {
        return $this->permissaoDeExcecaoModel
                                ->where("usuario_uuid", $usuarioUuid)
                                ->where("excluido", 0)
                                ->get();;
    }

    public function create(array $data): PermissaoDeExcecaoModel
    {
        return $this->permissaoDeExcecaoModel->create($data);
    }

    public function update(PermissaoDeExcecaoModel $permissaoDeExcecao, array $data): ?PermissaoDeExcecaoModel
    {
        $permissaoDeExcecao->update($data);
        return $permissaoDeExcecao;
    }

    public function delete(PermissaoDeExcecaoModel $permissaoDeExcecao, array $data): bool
    {
        $permissaoDeExcecao->fill($data);
        return $permissaoDeExcecao->save();
    }
}

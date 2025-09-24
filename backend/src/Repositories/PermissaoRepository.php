<?php

namespace App\Repositories;

use App\Models\PermissaoModel;
use Illuminate\Database\Eloquent\Collection;

class PermissaoRepository
{
    protected PermissaoModel $permissaoModel;

    public function __construct(PermissaoModel $permissaoModel) {
        $this->permissaoModel = $permissaoModel;
    }

    public function findAllWhere(array $conditions): Collection
    {
        return $this->permissaoModel->where($conditions)->get();
    }

    public function findAllInUuidList(array $uuids): Collection
    {
    return $this->permissaoModel->whereIn('uuid', $uuids)
                                ->where('excluido', 0)
                                ->get();
    }

    public function findByUuid(string $uuid): ?PermissaoModel
    {
        return $this->permissaoModel->find($uuid);
    }

    public function create(array $data): PermissaoModel
    {
        return $this->permissaoModel->create($data);
    }

    public function update(PermissaoModel $permissao, array $data): ?PermissaoModel
    {
        $permissao->update($data);
        return $permissao;
    }

    public function delete(PermissaoModel $permissao, array $data): bool
    {
        $permissao->fill($data);
        return $permissao->save();
    }
}

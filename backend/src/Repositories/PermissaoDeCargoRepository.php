<?php

namespace App\Repositories;

use App\Models\PermissaoDeCargoModel;
use Illuminate\Database\Eloquent\Collection;

class PermissaoDeCargoRepository
{
    protected PermissaoDeCargoModel $permissaoDeCargoModel;

    public function __construct(PermissaoDeCargoModel $permissaoDeCargoModel) {
        $this->permissaoDeCargoModel = $permissaoDeCargoModel;
    }

    public function findAllWhere(array $conditions): Collection
    {
        return $this->permissaoDeCargoModel->where($conditions)->get();
    }
    public function findByCargoUuid(string $cargoUuid): Collection
    {
        return $this->permissaoDeCargoModel->where("cargo_uuid", $cargoUuid)->where('excluido', 0)->get();
    }

    public function findByUuid(string $uuid): ?PermissaoDeCargoModel
    {
        return $this->permissaoDeCargoModel->find($uuid);
    }

    public function create(array $data): PermissaoDeCargoModel
    {
        return $this->permissaoDeCargoModel->create($data);
    }

    public function update(PermissaoDeCargoModel $permissaoDeCargo, array $data): ?PermissaoDeCargoModel
    {
        $permissaoDeCargo->update($data);
        return $permissaoDeCargo;
    }

    public function delete(PermissaoDeCargoModel $permissaoDeCargo, array $data): bool
    {
        $permissaoDeCargo->fill($data);
        return $permissaoDeCargo->save();
    }
}

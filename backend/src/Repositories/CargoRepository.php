<?php

namespace App\Repositories;

use App\Models\CargoModel;
use Illuminate\Database\Eloquent\Collection;

class CargoRepository
{
    protected CargoModel $cargoModel;

    public function __construct(CargoModel $cargoModel) {
        $this->cargoModel = $cargoModel;
    }

    public function findAllWhere(array $conditions): Collection
    {
        return $this->cargoModel->where($conditions)->get();
    }

    public function findByUuid(string $uuid): ?CargoModel
    {
        return $this->cargoModel->find($uuid);
    }

    public function create(array $data): CargoModel
    {
        return $this->cargoModel->create($data);
    }

    public function update(CargoModel $cargo, array $data): ?CargoModel
    {
        $cargo->update($data);
        return $cargo;
    }

    public function delete(CargoModel $cargo, array $data): bool
    {
        $cargo->fill($data);
        return $cargo->save();
    }
}

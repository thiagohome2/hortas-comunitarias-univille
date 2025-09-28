<?php

namespace App\Repositories;

use App\Models\CanteiroModel;
use Illuminate\Database\Eloquent\Collection;

class CanteiroRepository
{
    protected CanteiroModel $canteiroModel;

    public function __construct(CanteiroModel $canteiroModel) {
        $this->canteiroModel = $canteiroModel;
    }

    public function findAllWhere(array $conditions): Collection
    {
        return $this->canteiroModel->where($conditions)->get();
    }

    public function findByUuid(string $uuid): ?CanteiroModel
    {
        return $this->canteiroModel->find($uuid);
    }

    public function create(array $data): CanteiroModel
    {
        return $this->canteiroModel->create($data);
    }

    public function update(CanteiroModel $canteiro, array $data): ?CanteiroModel
    {
        $canteiro->update($data);
        return $canteiro;
    }

    public function delete(CanteiroModel $canteiro, array $data): bool
    {
        $canteiro->fill($data);
        return $canteiro->save();
    }
}

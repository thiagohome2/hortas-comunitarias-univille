<?php
namespace App\Repositories;

use App\Models\CargoModel;

class CargoRepository
{
    public function __construct(private CargoModel $model){}

    public function findAll(): array { return $this->model->all()->toArray(); }
    public function findByUuid(string $uuid): ?CargoModel { return $this->model->find($uuid); }
    public function existsByUuid(string $uuid): bool { return $this->model->find($uuid) ? true : false; }
    public function create(array $data): CargoModel { return $this->model->create($data); }
    public function update(string $uuid, array $data): ?CargoModel {
        $cargo = $this->model->find($uuid);
        if (!$cargo) return null;
        $cargo->update($data);
        return $cargo;
    }
    public function delete(string $uuid): bool {
        $cargo = $this->model->find($uuid);
        if (!$cargo) return false;
        return $cargo->delete();
    }
}

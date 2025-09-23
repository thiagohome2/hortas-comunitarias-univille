<?php

namespace App\Repositories;

use App\Models\HortaModel;

class HortaRepository
{
    protected HortaModel $model;

    public function __construct(HortaModel $model)
    {
        $this->model = $model;
    }

    public function findAll()
    {
        return $this->model->all();
    }

    public function findByUuid(string $uuid)
    {
        return $this->model->where('uuid', $uuid)->first();
    }

    public function existsByUuid(string $uuid): bool { return $this->model->find($uuid) ? true : false; }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(string $uuid, array $data)
    {
        $horta = $this->findByUuid($uuid);
        if ($horta) {
            $horta->update($data);
        }
        return $horta;
    }

    public function delete(string $uuid)
    {
        $horta = $this->findByUuid($uuid);
        if ($horta) {
            $horta->delete();
        }
        return $horta;
    }
}

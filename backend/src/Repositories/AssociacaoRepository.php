<?php

namespace App\Repositories;

use App\Models\AssociacaoModel;

class AssociacaoRepository
{
    protected AssociacaoModel $model;

    public function __construct(AssociacaoModel $model)
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
        $associacao = $this->findByUuid($uuid);
        if ($associacao) {
            $associacao->update($data);
        }
        return $associacao;
    }

    public function delete(string $uuid)
    {
        $associacao = $this->findByUuid($uuid);
        if ($associacao) {
            $associacao->delete();
        }
        return $associacao;
    }
}

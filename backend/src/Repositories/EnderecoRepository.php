<?php

namespace App\Repositories;

use App\Models\EnderecoModel;

class EnderecoRepository
{
    protected EnderecoModel $model;

    public function __construct(EnderecoModel $model)
    {
        $this->model = $model;
    }

    public function findAll()
    {
        return $this->model->all();
    }
    public function existsByUuid(string $uuid): bool { return $this->model->find($uuid) ? true : false; }
    public function findByUuid(string $uuid)
    {
        return $this->model->where('uuid', $uuid)->first();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(string $uuid, array $data)
    {
        $endereco = $this->findByUuid($uuid);
        if ($endereco) {
            $endereco->update($data);
        }
        return $endereco;
    }

    public function delete(string $uuid)
    {
        $endereco = $this->findByUuid($uuid);
        if ($endereco) {
            $endereco->delete();
        }
        return $endereco;
    }
}

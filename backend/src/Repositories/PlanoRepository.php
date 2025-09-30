<?php

namespace App\Repositories;

use App\Models\PlanoModel;
use Illuminate\Database\Eloquent\Collection;

class PlanoRepository
{
    protected PlanoModel $planoModel;

    public function __construct(PlanoModel $planoModel) {
        $this->planoModel = $planoModel;
    }

    public function findAllWhere(array $conditions): Collection
    {
        return $this->planoModel->where($conditions)->get();
    }

    public function findByUuid(string $uuid): ?PlanoModel
    {
        return $this->planoModel->find($uuid);
    }

    public function findBySlug(string $slug): ?PlanoModel
    {
        return $this->planoModel->where("slug", $slug)->first();
    }

    public function create(array $data): PlanoModel
    {
        return $this->planoModel->create($data);
    }

    public function update(PlanoModel $plano, array $data): ?PlanoModel
    {
        $plano->update($data);
        return $plano;
    }

    public function delete(PlanoModel $plano, array $data): bool
    {
        $plano->fill($data);
        return $plano->save();
    }
}

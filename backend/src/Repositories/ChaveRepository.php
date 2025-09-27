<?php

namespace App\Repositories;

use App\Models\ChaveModel;
use Illuminate\Database\Eloquent\Collection;

class ChaveRepository
{
    protected ChaveModel $chaveModel;

    public function __construct(ChaveModel $chaveModel) {
        $this->chaveModel = $chaveModel;
    }

    public function findAllWhere(array $conditions): Collection
    {
        return $this->chaveModel->where($conditions)->get();
    }

    public function findByUuid(string $uuid): ?ChaveModel
    {
        return $this->chaveModel->find($uuid);
    }

    public function findByHortaUuid(string $hortaUuid): Collection
    {
        return $this->chaveModel
            ->where("horta_uuid", $hortaUuid)
            ->where('excluido', 0)
            ->get();
    }

    public function create(array $data): ChaveModel
    {
        return $this->chaveModel->create($data);
    }

    public function update(ChaveModel $chave, array $data): ?ChaveModel
    {
        $chave->update($data);
        return $chave;
    }

    public function delete(ChaveModel $chave, array $data): bool
    {
        $chave->fill($data);
        return $chave->save();
    }
}

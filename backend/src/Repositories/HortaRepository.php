<?php

namespace App\Repositories;

use App\Models\HortaModel;
use Illuminate\Database\Eloquent\Collection;

class HortaRepository
{
    protected HortaModel $hortaModel;

    public function __construct(HortaModel $hortaModel)
    {
        $this->hortaModel = $hortaModel;
    }

    public function findAllWhere(array $conditions): Collection
    {
        return $this->hortaModel->where($conditions)->get();
    }

    public function findByUuid(string $uuid): ?HortaModel
    {
        return $this->hortaModel->find($uuid);
    }
    
    public function create(array $data): HortaModel
    {
        return $this->hortaModel->create($data);
    }
    
    public function update(HortaModel $horta, array $data): HortaModel
    {
        $horta->update($data);
        return $horta;
    }

    public function delete(HortaModel $horta, array $data): bool
    {
        $horta->fill($data);
        return $horta->save();
    }
}


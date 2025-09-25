<?php

namespace App\Repositories;

use App\Models\RecursoDoPlanoModel;
use Illuminate\Database\Eloquent\Collection;

class RecursoDoPlanoRepository
{
    protected RecursoDoPlanoModel $recursoDoPlanoModel;

    public function __construct(RecursoDoPlanoModel $recursoDoPlanoModel) {
        $this->recursoDoPlanoModel = $recursoDoPlanoModel;
    }

    public function findAllWhere(array $conditions): Collection
    {
        return $this->recursoDoPlanoModel->where($conditions)->get();
    }

    public function findByUuid(string $uuid): ?RecursoDoPlanoModel
    {
        return $this->recursoDoPlanoModel->find($uuid);
    }
    
    public function findByPlanoUuid(string $planoUuid): ?Collection
    {
        return $this->recursoDoPlanoModel
        ->where("plano_uuid", $planoUuid)
        ->where("excluido", 0)
        ->get();
    }

    public function create(array $data): RecursoDoPlanoModel
    {
        return $this->recursoDoPlanoModel->create($data);
    }

    public function update(RecursoDoPlanoModel $recursoDoPlano, array $data): ?RecursoDoPlanoModel
    {
        $recursoDoPlano->update($data);
        return $recursoDoPlano;
    }

    public function delete(RecursoDoPlanoModel $recursoDoPlano, array $data): bool
    {
        $recursoDoPlano->fill($data);
        return $recursoDoPlano->save();
    }
}

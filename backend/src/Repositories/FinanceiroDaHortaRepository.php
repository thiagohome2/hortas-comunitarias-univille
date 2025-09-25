<?php

namespace App\Repositories;

use App\Models\FinanceiroDaHortaModel;
use Illuminate\Database\Eloquent\Collection;

class FinanceiroDaHortaRepository
{
    protected FinanceiroDaHortaModel $financeiroDaHortaModel;

    public function __construct(FinanceiroDaHortaModel $financeiroDaHortaModel) {
        $this->financeiroDaHortaModel = $financeiroDaHortaModel;
    }

    public function findAllWhere(array $conditions): Collection
    {
        return $this->financeiroDaHortaModel->where($conditions)->get();
    }

    public function findByUuid(string $uuid): ?FinanceiroDaHortaModel
    {
        return $this->financeiroDaHortaModel->find($uuid);
    }

    public function create(array $data): FinanceiroDaHortaModel
    {
        return $this->financeiroDaHortaModel->create($data);
    }

    public function findByHortaUuid(string $hortaUuid): Collection
    {
        return $this->financeiroDaHortaModel
        ->where("horta_uuid", $hortaUuid)
        ->where('excluido', 0)
        ->get();
    }

    public function update(FinanceiroDaHortaModel $financeiroHorta, array $data): ?FinanceiroDaHortaModel
    {
        $financeiroHorta->update($data);
        return $financeiroHorta;
    }

    public function delete(FinanceiroDaHortaModel $financeiroHorta, array $data): bool
    {
        $financeiroHorta->fill($data);
        return $financeiroHorta->save();
    }
}

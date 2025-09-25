<?php

namespace App\Repositories;

use App\Models\FinanceiroDaAssociacaoModel;
use Illuminate\Database\Eloquent\Collection;

class FinanceiroDaAssociacaoRepository
{
    protected FinanceiroDaAssociacaoModel $financeiroDaAssociacaoModel;

    public function __construct(FinanceiroDaAssociacaoModel $financeiroDaAssociacaoModel) {
        $this->financeiroDaAssociacaoModel = $financeiroDaAssociacaoModel;
    }

    public function findAllWhere(array $conditions): Collection
    {
        return $this->financeiroDaAssociacaoModel->where($conditions)->get();
    }

    public function findByUuid(string $uuid): ?FinanceiroDaAssociacaoModel
    {
        return $this->financeiroDaAssociacaoModel->find($uuid);
    }

    public function findByAssociacaoUuid(string $associacaoUuid): Collection
    {
        return $this->financeiroDaAssociacaoModel
        ->where("associacao_uuid", $associacaoUuid)
        ->where('excluido', 0)
        ->get();
    }

    public function create(array $data): FinanceiroDaAssociacaoModel
    {
        return $this->financeiroDaAssociacaoModel->create($data);
    }

    public function update(FinanceiroDaAssociacaoModel $financeiroDaAssociacao, array $data): ?FinanceiroDaAssociacaoModel
    {
        $financeiroDaAssociacao->update($data);
        return $financeiroDaAssociacao;
    }

    public function delete(FinanceiroDaAssociacaoModel $financeiroDaAssociacao, array $data): bool
    {
        $financeiroDaAssociacao->fill($data);
        return $financeiroDaAssociacao->save();
    }
}

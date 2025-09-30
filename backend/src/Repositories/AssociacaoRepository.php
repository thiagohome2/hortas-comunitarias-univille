<?php

namespace App\Repositories;

use App\Models\AssociacaoModel;
use Illuminate\Database\Eloquent\Collection;

class AssociacaoRepository
{
    protected AssociacaoModel $associacaoModel;

    public function __construct(AssociacaoModel $associacaoModel)
    {
        $this->associacaoModel = $associacaoModel;
    }

    public function findAllWhere(array $conditions): Collection
    {
        return $this->associacaoModel->where($conditions)->get();
    }

    public function findByUuid(string $uuid): ?AssociacaoModel
    {
        return $this->associacaoModel->find($uuid);
    }
    public function findByCnpj(string $cnpj): ?AssociacaoModel
    {
        return $this->associacaoModel->where('cnpj', $cnpj)->first();
    }

    public function create(array $data): AssociacaoModel
    {
        return $this->associacaoModel->create($data);
    }

    public function update(AssociacaoModel $associacao, array $data): AssociacaoModel
    {
        $associacao->update($data);
        return $associacao;
    }

    public function delete(AssociacaoModel $associacao, array $data): bool
    {
        $associacao->fill($data);
        return $associacao->save();
    }
}

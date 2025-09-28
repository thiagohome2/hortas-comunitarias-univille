<?php

namespace App\Repositories;

use App\Models\CategoriaFinanceiraModel;
use Illuminate\Database\Eloquent\Collection;

class CategoriaFinanceiraRepository
{
    protected CategoriaFinanceiraModel $categoriaFinanceiraModel;

    public function __construct(CategoriaFinanceiraModel $categoriaFinanceiraModel) {
        $this->categoriaFinanceiraModel = $categoriaFinanceiraModel;
    }

    public function findAllWhere(array $conditions): Collection
    {
        return $this->categoriaFinanceiraModel->where($conditions)->get();
    }

    public function findAllInUuidList(array $uuids): Collection
    {
    return $this->categoriaFinanceiraModel->whereIn('uuid', $uuids)
                                ->where('excluido', 0)
                                ->get();
    }

    public function findByUuid(string $uuid): ?CategoriaFinanceiraModel
    {
        return $this->categoriaFinanceiraModel->find($uuid);
    }

    public function findByHortaUuid(string $hortaUuid): Collection
    {
        return $this->categoriaFinanceiraModel
        ->where("horta_uuid", $hortaUuid)
        ->where('excluido', 0)
        ->get();
    }
    public function findByAssociacaoUuid(string $associacaoUuid): Collection
    {
        return $this->categoriaFinanceiraModel
        ->where("associacao_uuid", $associacaoUuid)
        ->where('excluido', 0)
        ->get();
    }

    public function create(array $data): CategoriaFinanceiraModel
    {
        return $this->categoriaFinanceiraModel->create($data);
    }

    public function update(CategoriaFinanceiraModel $categoriaFinanceira, array $data): ?CategoriaFinanceiraModel
    {
        $categoriaFinanceira->update($data);
        return $categoriaFinanceira;
    }

    public function delete(CategoriaFinanceiraModel $categoriaFinanceira, array $data): bool
    {
        $categoriaFinanceira->fill($data);
        return $categoriaFinanceira->save();
    }
}

<?php

namespace App\Repositories;

use App\Models\EnderecoModel;
use Illuminate\Database\Eloquent\Collection;

class EnderecoRepository
{
    protected EnderecoModel $enderecoModel;

    public function __construct(EnderecoModel $enderecoModel)
    {
        $this->enderecoModel = $enderecoModel;
    }

   public function findAllWhere(array $conditions): Collection
    {
        return $this->enderecoModel->where($conditions)->get();
    }

    public function findByUuid(string $uuid): ?EnderecoModel
    {
        return $this->enderecoModel->find($uuid);
    }
    
    public function create(array $data): EnderecoModel
    {
        return $this->enderecoModel->create($data);
    }
    
    public function update(EnderecoModel $endereco, array $data): EnderecoModel
    {
        $endereco->update($data);
        return $endereco;
    }

    public function delete(EnderecoModel $endereco, array $data): bool
    {
        $endereco->fill($data);
        return $endereco->save();
    }
}

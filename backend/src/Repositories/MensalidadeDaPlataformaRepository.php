<?php

namespace App\Repositories;

use App\Models\MensalidadeDaPlataformaModel;
use Illuminate\Database\Eloquent\Collection;

class MensalidadeDaPlataformaRepository
{
    protected MensalidadeDaPlataformaModel $mensalidadeDaPlataformaModel;

    public function __construct(MensalidadeDaPlataformaModel $mensalidadeDaPlataformaModel) {
        $this->mensalidadeDaPlataformaModel = $mensalidadeDaPlataformaModel;
    }

    public function findAllWhere(array $conditions): Collection
    {
        return $this->mensalidadeDaPlataformaModel->where($conditions)->get();
    }

    public function findByUuid(string $uuid): ?MensalidadeDaPlataformaModel
    {
        return $this->mensalidadeDaPlataformaModel->find($uuid);
    }

    public function create(array $data): MensalidadeDaPlataformaModel
    {
        return $this->mensalidadeDaPlataformaModel->create($data);
    }

    public function update(MensalidadeDaPlataformaModel $mensalidadeDaPlataforma, array $data): ?MensalidadeDaPlataformaModel
    {
        $mensalidadeDaPlataforma->update($data);
        return $mensalidadeDaPlataforma;
    }

    public function delete(MensalidadeDaPlataformaModel $mensalidadeDaPlataforma, array $data): bool
    {
        $mensalidadeDaPlataforma->fill($data);
        return $mensalidadeDaPlataforma->save();
    }
}

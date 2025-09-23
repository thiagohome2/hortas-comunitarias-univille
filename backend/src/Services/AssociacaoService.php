<?php

namespace App\Services;

use App\Repositories\AssociacaoRepository;
use Respect\Validation\Validator as v;

class AssociacaoService
{
    protected AssociacaoRepository $repository;

    public function __construct(AssociacaoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list()
    {
        return $this->repository->findAll();
    }

    public function get(string $uuid)
    {
        return $this->repository->findByUuid($uuid);
    }

    public function create(array $data, string $usuarioUuid)
    {
        // Define automaticamente o criador
        $data['usuario_criador_uuid'] = $usuarioUuid;

        // Validação
        v::key('cnpj', v::stringType()->notEmpty())
         ->key('razao_social', v::stringType()->notEmpty())
         ->assert($data);

        return $this->repository->create($data);
    }

    public function update(string $uuid, array $data, string $usuarioUuid)
    {
        $data['usuario_alterador_uuid'] = $usuarioUuid;

        // Validação (pode ser customizada)
        v::key('razao_social', v::optional(v::stringType()->notEmpty()))
         ->assert($data);

        return $this->repository->update($uuid, $data);
    }

    public function delete(string $uuid)
    {
        return $this->repository->delete($uuid);
    }
}

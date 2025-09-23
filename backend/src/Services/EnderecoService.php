<?php

namespace App\Services;

use App\Repositories\EnderecoRepository;
use Respect\Validation\Validator as v;

class EnderecoService
{
    protected EnderecoRepository $repository;

    public function __construct(EnderecoRepository $repository)
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
        $data['usuario_criador_uuid'] = $usuarioUuid;

        v::key('logradouro', v::stringType()->notEmpty())
         ->key('numero', v::stringType()->notEmpty())
         ->key('cidade', v::stringType()->notEmpty())
         ->key('estado', v::stringType()->length(2, 2))
         ->assert($data);

        return $this->repository->create($data);
    }

    public function update(string $uuid, array $data, string $usuarioUuid)
    {
        $data['usuario_alterador_uuid'] = $usuarioUuid;

        return $this->repository->update($uuid, $data);
    }

    public function delete(string $uuid)
    {
        return $this->repository->delete($uuid);
    }
}

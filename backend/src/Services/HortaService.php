<?php

namespace App\Services;

use App\Repositories\HortaRepository;
use Respect\Validation\Validator as v;

class HortaService
{
    protected HortaRepository $repository;

    public function __construct(HortaRepository $repository)
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

        v::key('nome_da_horta', v::stringType()->notEmpty())
         ->key('endereco_uuid', v::stringType()->notEmpty())
         ->key('associacao_vinculada_uuid', v::stringType()->notEmpty())
         ->assert($data);

        return $this->repository->create($data);
    }

    public function update(string $uuid, array $data, string $usuarioUuid)
    {
        $data['usuario_alterador_uuid'] = $usuarioUuid;

        v::key('nome_da_horta', v::optional(v::stringType()->notEmpty()))
         ->assert($data);

        return $this->repository->update($uuid, $data);
    }

    public function delete(string $uuid)
    {
        return $this->repository->delete($uuid);
    }
}

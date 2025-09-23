<?php
namespace App\Services;

use App\Repositories\CargoRepository;
use Respect\Validation\Validator as v;
use Psr\Http\Message\ServerRequestInterface as Request;

class CargoService
{
    public function __construct(private CargoRepository $repository){}

    public function listar(): array { return $this->repository->findAll(); }

    public function obter(string $uuid) { return $this->repository->findByUuid($uuid); }

    public function criar(array $data, Request $request){
        $data['usuario_criador_uuid'] = $request->getAttribute('usuario_uuid');
        $data['usuario_alterador_uuid'] = $request->getAttribute('usuario_uuid');

        v::key('codigo', v::intType()->between(0,5))
          ->key('slug', v::stringType()->notEmpty())
          ->key('nome', v::stringType()->notEmpty())
          ->check($data);

        return $this->repository->create($data);
    }

    public function atualizar(string $uuid, array $data, Request $request){
        $data['usuario_alterador_uuid'] = $request->getAttribute('usuario_uuid');
        return $this->repository->update($uuid, $data);
    }

    public function excluir(string $uuid){ return $this->repository->delete($uuid); }
}

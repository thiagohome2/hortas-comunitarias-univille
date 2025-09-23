<?php
namespace App\Controllers;

use App\Services\CargoService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CargoController
{
    protected CargoService $cargoService;
    public function __construct(CargoService $cargoService){
        $this->cargoService = $cargoService;
    }

    public function list(Request $request, Response $response)
    {
        $cargos = $this->cargoService->findAllWhere();
        $response->getBody()->write(json_encode($cargos));
        return $response->withStatus(200);
    }

    public function get(Request $request, Response $response, array $args)
    {
        $cargo = $this->cargoService->findByUuid($args['uuid']);
        if(!$cargo) return $response->withStatus(404);

        $response->getBody()->write(json_encode($cargo));
        return $response->withStatus(200);
    }

    public function create(Request $request, Response $response){
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $cargo = $this->cargoService->create($data,$uuidUsuarioLogado);

        $response->getBody()->write(json_encode($cargo));
        return $response->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $cargo = $this->cargoService->update($args['uuid'], $data, $uuidUsuarioLogado );
        
        $response->getBody()->write(json_encode($cargo));
        return $response->withStatus(200);
    }

    public function delete(Request $request, Response $response, array $args)
    {
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $this->cargoService->delete($args['uuid'], $uuidUsuarioLogado);

        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

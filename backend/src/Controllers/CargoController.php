<?php
namespace App\Controllers;

use App\Services\CargoService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CargoController
{
    public function __construct(private CargoService $service){}

    public function list(Request $request, Response $response){
        $response->getBody()->write(json_encode($this->service->listar()));
        return $response->withHeader('Content-Type','application/json');
    }

    public function get(Request $request, Response $response, array $args){
        $cargo = $this->service->obter($args['uuid']);
        $response->getBody()->write(json_encode($cargo));
        return $response->withHeader('Content-Type','application/json');
    }

    public function create(Request $request, Response $response){
        $data = (array)$request->getParsedBody();
        $cargo = $this->service->criar($data, $request);
        $response->getBody()->write(json_encode($cargo));
        return $response->withHeader('Content-Type','application/json');
    }

    public function update(Request $request, Response $response, array $args){
        $data = (array)$request->getParsedBody();
        $cargo = $this->service->atualizar($args['uuid'], $data, $request);
        $response->getBody()->write(json_encode($cargo));
        return $response->withHeader('Content-Type','application/json');
    }

    public function delete(Request $request, Response $response, array $args){
        $sucesso = $this->service->excluir($args['uuid']);
        $response->getBody()->write(json_encode(['success'=>$sucesso]));
        return $response->withHeader('Content-Type','application/json');
    }
}

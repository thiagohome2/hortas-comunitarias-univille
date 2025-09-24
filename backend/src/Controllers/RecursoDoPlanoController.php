<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\RecursoDoPlanoService;

class RecursoDoPlanoController
{
    protected RecursoDoPlanoService $recursoDoPlanoService;

    public function __construct(RecursoDoPlanoService $recursoDoPlanoService)
    {
        $this->recursoDoPlanoService = $recursoDoPlanoService;
    }

    public function list(Request $request, Response $response)
    {
        $recursosDoPlano = $this->recursoDoPlanoService->findAllWhere();
        $response->getBody()->write(json_encode($recursosDoPlano));
        return $response->withStatus(200);
    }

    public function get(Request $request, Response $response, array $args)
    {
        $recursoDoPlano = $this->recursoDoPlanoService->findByUuid($args['uuid']);
        if (!$recursoDoPlano) return $response->withStatus(404);

        $response->getBody()->write(json_encode($recursoDoPlano));
        return $response->withStatus(200);
    }

    public function create(Request $request, Response $response)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $recursoDoPlano = $this->recursoDoPlanoService->create($data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($recursoDoPlano));
        return $response->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $recursoDoPlano = $this->recursoDoPlanoService->update($args['uuid'], $data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($recursoDoPlano));
        return $response->withStatus(200);
    }

    public function delete(Request $request, Response $response, array $args){   
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $this->recursoDoPlanoService->delete($args['uuid'], $uuidUsuarioLogado);
        
        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\PlanoService;

class PlanoController
{
    protected PlanoService $planoService;

    public function __construct(PlanoService $planoService)
    {
        $this->planoService = $planoService;
    }

    public function list(Request $request, Response $response)
    {
        $planos = $this->planoService->findAllWhere();
        $response->getBody()->write(json_encode($planos));
        return $response->withStatus(200);
    }

    public function get(Request $request, Response $response, array $args)
    {
        $plano = $this->planoService->findByUuid($args['uuid']);
        if (!$plano) return $response->withStatus(404);

        $response->getBody()->write(json_encode($plano));
        return $response->withStatus(200);
    }

    public function create(Request $request, Response $response)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $plano = $this->planoService->create($data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($plano));
        return $response->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $plano = $this->planoService->update($args['uuid'], $data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($plano));
        return $response->withStatus(200);
    }

    public function delete(Request $request, Response $response, array $args){   
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $this->planoService->delete($args['uuid'], $uuidUsuarioLogado);
        
        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

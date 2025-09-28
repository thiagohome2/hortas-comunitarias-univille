<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\HortaService;

class HortaController
{
    protected HortaService $hortaService;

    public function __construct(HortaService $hortaService)
    {
        $this->hortaService = $hortaService;
    }

    
    public function list(Request $request, Response $response)
    {
        $hortas = $this->hortaService->findAllWhere();
        $response->getBody()->write(json_encode($hortas));
        return $response->withStatus(200);
    }

    public function get(Request $request, Response $response, array $args)
    {
        $horta = $this->hortaService->findByUuid($args['uuid']);
        if (!$horta) return $response->withStatus(404);

        $response->getBody()->write(json_encode($horta));
        return $response->withStatus(200);
    }

    public function create(Request $request, Response $response)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $horta = $this->hortaService->create($data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($horta));
        return $response->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $horta = $this->hortaService->update($args['uuid'], $data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($horta));
        return $response->withStatus(200);
    }

    public function delete(Request $request, Response $response, array $args){   
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $this->hortaService->delete($args['uuid'], $uuidUsuarioLogado);
        
        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

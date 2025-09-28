<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\ChaveService;

class ChaveController
{
    protected ChaveService $chaveService;

    public function __construct(ChaveService $chaveService)
    {
        $this->chaveService = $chaveService;
    }

    public function list(Request $request, Response $response)
    {
        $chaves = $this->chaveService->findAllWhere();
        $response->getBody()->write(json_encode($chaves));
        return $response->withStatus(200);
    }

    public function get(Request $request, Response $response, array $args)
    {
        $chave = $this->chaveService->findByUuid($args['uuid']);
        if (!$chave) return $response->withStatus(404);

        $response->getBody()->write(json_encode($chave));
        return $response->withStatus(200);
    }

    public function create(Request $request, Response $response)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $chave = $this->chaveService->create($data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($chave));
        return $response->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $chave = $this->chaveService->update($args['uuid'], $data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($chave));
        return $response->withStatus(200);
    }

    public function delete(Request $request, Response $response, array $args)
    {
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $this->chaveService->delete($args['uuid'], $uuidUsuarioLogado);

        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

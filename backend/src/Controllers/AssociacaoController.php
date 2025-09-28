<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\AssociacaoService;

class AssociacaoController
{
    protected AssociacaoService $associacaoService;

    public function __construct(AssociacaoService $associacaoService)
    {
        $this->associacaoService = $associacaoService;
    }

    public function list(Request $request, Response $response)
    {
        $associacoes = $this->associacaoService->findAllWhere();
        $response->getBody()->write(json_encode($associacoes));
        return $response->withStatus(200);
    }

    public function get(Request $request, Response $response, array $args)
    {
        $associacao = $this->associacaoService->findByUuid($args['uuid']);
        if (!$associacao) return $response->withStatus(404);

        $response->getBody()->write(json_encode($associacao));
        return $response->withStatus(200);
    }

    public function create(Request $request, Response $response)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $associacao = $this->associacaoService->create($data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($associacao));
        return $response->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $associacao = $this->associacaoService->update($args['uuid'], $data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($associacao));
        return $response->withStatus(200);
    }

    public function delete(Request $request, Response $response, array $args)
    {
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $this->associacaoService->delete($args['uuid'], $uuidUsuarioLogado);
        
        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

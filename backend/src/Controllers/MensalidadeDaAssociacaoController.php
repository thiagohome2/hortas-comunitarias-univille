<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\MensalidadeDaAssociacaoService;

class MensalidadeDaAssociacaoController
{
    protected MensalidadeDaAssociacaoService $mensalidadeDaAssociacaoService;

    public function __construct(MensalidadeDaAssociacaoService $mensalidadeDaAssociacaoService)
    {
        $this->mensalidadeDaAssociacaoService = $mensalidadeDaAssociacaoService;
    }

    public function list(Request $request, Response $response)
    {
        $mensalidadesDaAssociacao = $this->mensalidadeDaAssociacaoService->findAllWhere();
        $response->getBody()->write(json_encode($mensalidadesDaAssociacao));
        return $response->withStatus(200);
    }

    public function get(Request $request, Response $response, array $args)
    {
        $mensalidadeDaAssociacao = $this->mensalidadeDaAssociacaoService->findByUuid($args['uuid']);
        if (!$mensalidadeDaAssociacao) return $response->withStatus(404);

        $response->getBody()->write(json_encode($mensalidadeDaAssociacao));
        return $response->withStatus(200);
    }

    public function create(Request $request, Response $response)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $mensalidadeDaAssociacao = $this->mensalidadeDaAssociacaoService->create($data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($mensalidadeDaAssociacao));
        return $response->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $mensalidadeDaAssociacao = $this->mensalidadeDaAssociacaoService->update($args['uuid'], $data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($mensalidadeDaAssociacao));
        return $response->withStatus(200);
    }

    public function delete(Request $request, Response $response, array $args){   
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $this->mensalidadeDaAssociacaoService->delete($args['uuid'], $uuidUsuarioLogado);
        
        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

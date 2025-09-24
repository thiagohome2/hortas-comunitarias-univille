<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\FinanceiroDaAssociacaoService;

class FinanceiroDaAssociacaoController
{
    protected FinanceiroDaAssociacaoService $financeiroDaAssociacaoService;

    public function __construct(FinanceiroDaAssociacaoService $financeiroDaAssociacaoService)
    {
        $this->financeiroDaAssociacaoService = $financeiroDaAssociacaoService;
    }

    public function list(Request $request, Response $response)
    {
        $financeirosDaAssociacao = $this->financeiroDaAssociacaoService->findAllWhere();
        $response->getBody()->write(json_encode($financeirosDaAssociacao));
        return $response->withStatus(200);
    }

    public function get(Request $request, Response $response, array $args)
    {
        $financeiroDaAssociacao = $this->financeiroDaAssociacaoService->findByUuid($args['uuid']);
        if (!$financeiroDaAssociacao) return $response->withStatus(404);

        $response->getBody()->write(json_encode($financeiroDaAssociacao));
        return $response->withStatus(200);
    }

    public function create(Request $request, Response $response)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $financeiroDaAssociacao = $this->financeiroDaAssociacaoService->create($data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($financeiroDaAssociacao));
        return $response->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $financeiroDaAssociacao = $this->financeiroDaAssociacaoService->update($args['uuid'], $data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($financeiroDaAssociacao));
        return $response->withStatus(200);
    }

    public function delete(Request $request, Response $response, array $args){   
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $this->financeiroDaAssociacaoService->delete($args['uuid'], $uuidUsuarioLogado);
        
        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

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
        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        $financeirosDaAssociacao = $this->financeiroDaAssociacaoService->findAllWhere($payloadUsuarioLogado);
        $response->getBody()->write(json_encode($financeirosDaAssociacao));
        return $response->withStatus(200);
    }

    public function get(Request $request, Response $response, array $args)
    {
        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        $financeiroDaAssociacao = $this->financeiroDaAssociacaoService->findByUuid($args['uuid'], $payloadUsuarioLogado);
        if (!$financeiroDaAssociacao) return $response->withStatus(404);

        $response->getBody()->write(json_encode($financeiroDaAssociacao));
        return $response->withStatus(200);
    }

    public function getByAssociacao(Request $request, Response $response, array $args)
    {
        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        $financeirosDaAssociacao = $this->financeiroDaAssociacaoService->findByAssociacaoUuid($args['uuid'], $payloadUsuarioLogado);
        if ($financeirosDaAssociacao->isEmpty()) return $response->withStatus(404);

        $response->getBody()->write(json_encode($financeirosDaAssociacao));
        return $response->withStatus(200);
    }

    public function create(Request $request, Response $response)
    {
        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $financeiroDaAssociacao = $this->financeiroDaAssociacaoService->create($data, $payloadUsuarioLogado);

        $response->getBody()->write(json_encode($financeiroDaAssociacao));
        return $response->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $financeiroDaAssociacao = $this->financeiroDaAssociacaoService->update($args['uuid'], $data, $payloadUsuarioLogado);

        $response->getBody()->write(json_encode($financeiroDaAssociacao));
        return $response->withStatus(200);
    }

    public function delete(Request $request, Response $response, array $args){   
        
        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $this->financeiroDaAssociacaoService->delete($args['uuid'], $payloadUsuarioLogado, $payloadUsuarioLogado);
        
        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

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
        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        
        $associacoes = $this->associacaoService->findAllWhere($payloadUsuarioLogado);
        $response->getBody()->write(json_encode($associacoes));
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

        $associacao = $this->associacaoService->findByUuid($args['uuid'], $payloadUsuarioLogado);
        if (!$associacao) return $response->withStatus(404);

        $response->getBody()->write(json_encode($associacao));
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
        $associacao = $this->associacaoService->create($data, $payloadUsuarioLogado);

        $response->getBody()->write(json_encode($associacao));
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
        $associacao = $this->associacaoService->update($args['uuid'], $data, $payloadUsuarioLogado);

        $response->getBody()->write(json_encode($associacao));
        return $response->withStatus(200);
    }

    public function delete(Request $request, Response $response, array $args)
    {
                $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];

        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $this->associacaoService->delete($args['uuid'], $payloadUsuarioLogado);
        
        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

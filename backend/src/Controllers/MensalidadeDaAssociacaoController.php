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
        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        $mensalidadesDaAssociacao = $this->mensalidadeDaAssociacaoService->findAllWhere($payloadUsuarioLogado);
        $response->getBody()->write(json_encode($mensalidadesDaAssociacao));
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
        $mensalidadeDaAssociacao = $this->mensalidadeDaAssociacaoService->findByUuid($args['uuid'], $payloadUsuarioLogado);
        if (!$mensalidadeDaAssociacao) return $response->withStatus(404);

        $response->getBody()->write(json_encode($mensalidadeDaAssociacao));
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
        $mensalidadesDaAssociacao = $this->mensalidadeDaAssociacaoService->findByAssociacaoUuid($args['uuid'], $payloadUsuarioLogado);
        if ($mensalidadesDaAssociacao->isEmpty()) return $response->withStatus(404);

        $response->getBody()->write(json_encode($mensalidadesDaAssociacao));
        return $response->withStatus(200);
    }
    public function getByUsuario(Request $request, Response $response, array $args)
    {
        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        $mensalidadesDoUsuario = $this->mensalidadeDaAssociacaoService->findByUsuarioUuid($args['uuid'], $payloadUsuarioLogado);
        if ($mensalidadesDoUsuario->isEmpty()) return $response->withStatus(404);

        $response->getBody()->write(json_encode($mensalidadesDoUsuario));
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
        $mensalidadeDaAssociacao = $this->mensalidadeDaAssociacaoService->create($data, $payloadUsuarioLogado);

        $response->getBody()->write(json_encode($mensalidadeDaAssociacao));
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
        $mensalidadeDaAssociacao = $this->mensalidadeDaAssociacaoService->update($args['uuid'], $data, $payloadUsuarioLogado);

        $response->getBody()->write(json_encode($mensalidadeDaAssociacao));
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
        $this->mensalidadeDaAssociacaoService->delete($args['uuid'], $payloadUsuarioLogado);
        
        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

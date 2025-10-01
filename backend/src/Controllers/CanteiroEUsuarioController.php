<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\CanteiroEUsuarioService;

class CanteiroEUsuarioController
{
    protected CanteiroEUsuarioService $canteiroEUsuarioService;

    public function __construct(CanteiroEUsuarioService $canteiroEUsuarioService)
    {
        $this->canteiroEUsuarioService = $canteiroEUsuarioService;
    }

    
    public function list(Request $request, Response $response)
    {
        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        $canteiroEUsuarios = $this->canteiroEUsuarioService->findAllWhere($payloadUsuarioLogado);
        $response->getBody()->write(json_encode($canteiroEUsuarios));
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
        $canteiroEUsuario = $this->canteiroEUsuarioService->findByUuid($args['uuid'], $payloadUsuarioLogado);
        if (!$canteiroEUsuario) return $response->withStatus(404);

        $response->getBody()->write(json_encode($canteiroEUsuario));
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
        $canteiroEUsuario = $this->canteiroEUsuarioService->create($data, $payloadUsuarioLogado);

        $response->getBody()->write(json_encode($canteiroEUsuario));
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
        $canteiroEUsuario = $this->canteiroEUsuarioService->update($args['uuid'], $data, $payloadUsuarioLogado);

        $response->getBody()->write(json_encode($canteiroEUsuario));
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
        $this->canteiroEUsuarioService->delete($args['uuid'], $payloadUsuarioLogado);
        
        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

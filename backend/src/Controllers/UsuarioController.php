<?php

namespace App\Controllers;

use App\Services\UsuarioService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UsuarioController
{
    protected $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function list(Request $request, Response $response)
    {
        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];

        $usuarios = $this->usuarioService->findAllWhere($payloadUsuarioLogado);
        $response->getBody()->write(json_encode($usuarios));
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

        $usuario = $this->usuarioService->findByUuid($args['uuid'], $payloadUsuarioLogado);
        if (!$usuario) return $response->withStatus(404);

        $response->getBody()->write(json_encode($usuario));
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
        $usuario = $this->usuarioService->create($data, $uuidUsuarioLogado, $payloadUsuarioLogado);

        $response->getBody()->write(json_encode($usuario));
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
        $usuario = $this->usuarioService->update($args['uuid'], $data, $uuidUsuarioLogado, $payloadUsuarioLogado);

        $response->getBody()->write(json_encode($usuario));
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
        $this->usuarioService->delete($args['uuid'], $uuidUsuarioLogado, $payloadUsuarioLogado);
        
        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\FilaDeUsuarioService;

class FilaDeUsuarioController
{
    protected FilaDeUsuarioService $filaDeUsuariosService;

    public function __construct(FilaDeUsuarioService $filaDeUsuariosService)
    {
        $this->filaDeUsuariosService = $filaDeUsuariosService;
    }

    public function list(Request $request, Response $response)
    {
        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        $fila = $this->filaDeUsuariosService->findAllWhere($payloadUsuarioLogado);
        $response->getBody()->write(json_encode($fila));
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
        $fila = $this->filaDeUsuariosService->findByUuid($args['uuid'], $payloadUsuarioLogado);
        if (!$fila) return $response->withStatus(404);

        $response->getBody()->write(json_encode($fila));
        return $response->withStatus(200);
    }

    public function getByHorta(Request $request, Response $response, array $args)
    {
        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        $fila = $this->filaDeUsuariosService->findByHortaUuid($args['uuid'], $payloadUsuarioLogado);
        if ($fila->isEmpty()) return $response->withStatus(404);

        $response->getBody()->write(json_encode($fila));
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
        $fila = $this->filaDeUsuariosService->findByUsuarioUuid($args['uuid'], $payloadUsuarioLogado);
        if ($fila->isEmpty()) return $response->withStatus(404);

        $response->getBody()->write(json_encode($fila));
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
        $fila = $this->filaDeUsuariosService->create($data, $payloadUsuarioLogado);

        $response->getBody()->write(json_encode($fila));
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
        $fila = $this->filaDeUsuariosService->update($args['uuid'], $data, $payloadUsuarioLogado);

        $response->getBody()->write(json_encode($fila));
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
        $this->filaDeUsuariosService->delete($args['uuid'], $payloadUsuarioLogado);

        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

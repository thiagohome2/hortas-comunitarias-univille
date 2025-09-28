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
        $usuarios = $this->usuarioService->findAllWhere();
        $response->getBody()->write(json_encode($usuarios));
        return $response->withStatus(200);
    }

    public function get(Request $request, Response $response, array $args)
    {
        $usuario = $this->usuarioService->findByUuid($args['uuid']);
        if (!$usuario) return $response->withStatus(404);

        $response->getBody()->write(json_encode($usuario));
        return $response->withStatus(200);
    }

    public function create(Request $request, Response $response)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $usuario = $this->usuarioService->create($data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($usuario));
        return $response->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $usuario = $this->usuarioService->update($args['uuid'], $data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($usuario));
        return $response->withStatus(200);
    }

    public function delete(Request $request, Response $response, array $args){   
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $this->usuarioService->delete($args['uuid'], $uuidUsuarioLogado);
        
        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

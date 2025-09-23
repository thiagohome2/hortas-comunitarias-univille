<?php

namespace App\Controllers;

use App\Services\UsuarioService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UsuarioController
{
    protected $service;

    public function __construct(UsuarioService $service)
    {
        $this->service = $service;
    }

    public function list(Request $request, Response $response)
    {
        $usuarios = $this->service->listAll();
        $response->getBody()->write(json_encode($usuarios));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function get(Request $request, Response $response, array $args)
    {
        $usuario = $this->service->getByUuid($args['uuid']);
        if (!$usuario) return $response->withStatus(404);

        $response->getBody()->write(json_encode($usuario));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function create(Request $request, Response $response)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $usuario = $this->service->create($data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($usuario));
        return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
    }

    public function update(Request $request, Response $response, array $args)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid'); // do JWT
        $usuario = $this->service->update($args['uuid'], $data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($usuario));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function delete(Request $request, Response $response, array $args)
    {
        $this->service->delete($args['uuid']);
        return $response->withStatus(204);
    }
}

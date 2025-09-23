<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\HortaService;

class HortaController
{
    protected HortaService $service;

    public function __construct(HortaService $service)
    {
        $this->service = $service;
    }

    public function list(Request $request, Response $response)
    {
        $result = $this->service->list();
        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function get(Request $request, Response $response, array $args)
    {
        $result = $this->service->get($args['uuid']);
        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function create(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $usuarioUuid = $request->getAttribute('usuario_uuid');

        $result = $this->service->create($data, $usuarioUuid);
        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function update(Request $request, Response $response, array $args)
    {
        $data = $request->getParsedBody();
        $usuarioUuid = $request->getAttribute('usuario_uuid');

        $result = $this->service->update($args['uuid'], $data, $usuarioUuid);
        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function delete(Request $request, Response $response, array $args)
    {
        $result = $this->service->delete($args['uuid']);
        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json');
    }
}

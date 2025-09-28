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
        $fila = $this->filaDeUsuariosService->findAllWhere();
        $response->getBody()->write(json_encode($fila));
        return $response->withStatus(200);
    }

    public function get(Request $request, Response $response, array $args)
    {
        $fila = $this->filaDeUsuariosService->findByUuid($args['uuid']);
        if (!$fila) return $response->withStatus(404);

        $response->getBody()->write(json_encode($fila));
        return $response->withStatus(200);
    }

    public function getByHorta(Request $request, Response $response, array $args)
    {
        $fila = $this->filaDeUsuariosService->findByHortaUuid($args['uuid']);
        if ($fila->isEmpty()) return $response->withStatus(404);

        $response->getBody()->write(json_encode($fila));
        return $response->withStatus(200);
    }

    public function getByUsuario(Request $request, Response $response, array $args)
    {
        $fila = $this->filaDeUsuariosService->findByUsuarioUuid($args['uuid']);
        if ($fila->isEmpty()) return $response->withStatus(404);

        $response->getBody()->write(json_encode($fila));
        return $response->withStatus(200);
    }

    public function create(Request $request, Response $response)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $fila = $this->filaDeUsuariosService->create($data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($fila));
        return $response->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $fila = $this->filaDeUsuariosService->update($args['uuid'], $data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($fila));
        return $response->withStatus(200);
    }

    public function delete(Request $request, Response $response, array $args)
    {
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $this->filaDeUsuariosService->delete($args['uuid'], $uuidUsuarioLogado);

        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

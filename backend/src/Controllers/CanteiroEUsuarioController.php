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
        $canteiroEUsuarios = $this->canteiroEUsuarioService->findAllWhere();
        $response->getBody()->write(json_encode($canteiroEUsuarios));
        return $response->withStatus(200);
    }

    public function get(Request $request, Response $response, array $args)
    {
        $canteiroEUsuario = $this->canteiroEUsuarioService->findByUuid($args['uuid']);
        if (!$canteiroEUsuario) return $response->withStatus(404);

        $response->getBody()->write(json_encode($canteiroEUsuario));
        return $response->withStatus(200);
    }

    public function create(Request $request, Response $response)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $canteiroEUsuario = $this->canteiroEUsuarioService->create($data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($canteiroEUsuario));
        return $response->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $canteiroEUsuario = $this->canteiroEUsuarioService->update($args['uuid'], $data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($canteiroEUsuario));
        return $response->withStatus(200);
    }

    public function delete(Request $request, Response $response, array $args){   
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $this->canteiroEUsuarioService->delete($args['uuid'], $uuidUsuarioLogado);
        
        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

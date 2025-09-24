<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\PermissaoService;

class PermissaoController
{
    protected PermissaoService $permissaoService;

    public function __construct(PermissaoService $permissaoService)
    {
        $this->permissaoService = $permissaoService;
    }

    
    public function list(Request $request, Response $response)
    {
        $permicoes = $this->permissaoService->findAllWhere();
        $response->getBody()->write(json_encode($permicoes));
        return $response->withStatus(200);
    }

    public function get(Request $request, Response $response, array $args)
    {
        $permissao = $this->permissaoService->findByUuid($args['uuid']);
        if (!$permissao) return $response->withStatus(404);

        $response->getBody()->write(json_encode($permissao));
        return $response->withStatus(200);
    }

    public function create(Request $request, Response $response)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $permissao = $this->permissaoService->create($data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($permissao));
        return $response->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $permissao = $this->permissaoService->update($args['uuid'], $data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($permissao));
        return $response->withStatus(200);
    }

    public function delete(Request $request, Response $response, array $args){   
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $this->permissaoService->delete($args['uuid'], $uuidUsuarioLogado);
        
        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

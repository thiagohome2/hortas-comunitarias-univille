<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\PermissaoDeExcecaoService;

class PermissaoDeExcecaoController
{
    protected PermissaoDeExcecaoService $permissaoDeExcecaoService;

    public function __construct(PermissaoDeExcecaoService $permissaoDeExcecaoService)
    {
        $this->permissaoDeExcecaoService = $permissaoDeExcecaoService;
    }

    
    public function list(Request $request, Response $response)
    {
        $permicoesDeExcecao = $this->permissaoDeExcecaoService->findAllWhere();
        $response->getBody()->write(json_encode($permicoesDeExcecao));
        return $response->withStatus(200);
    }

    public function get(Request $request, Response $response, array $args)
    {
        $permissaoDeExcecao = $this->permissaoDeExcecaoService->findByUuid($args['uuid']);
        if (!$permissaoDeExcecao) return $response->withStatus(404);

        $response->getBody()->write(json_encode($permissaoDeExcecao));
        return $response->withStatus(200);
    }

    public function create(Request $request, Response $response)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $permissaoDeExcecao = $this->permissaoDeExcecaoService->create($data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($permissaoDeExcecao));
        return $response->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $permissaoDeExcecao = $this->permissaoDeExcecaoService->update($args['uuid'], $data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($permissaoDeExcecao));
        return $response->withStatus(200);
    }

    public function delete(Request $request, Response $response, array $args){   
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $this->permissaoDeExcecaoService->delete($args['uuid'], $uuidUsuarioLogado);
        
        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

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
    {        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
            'interno' => false
        ];
        $permicoesDeExcecao = $this->permissaoDeExcecaoService->findAllWhere($payloadUsuarioLogado);
        $response->getBody()->write(json_encode($permicoesDeExcecao));
        return $response->withStatus(200);
    }

    public function get(Request $request, Response $response, array $args)
    {        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
            'interno' => false
        ];
        $permissaoDeExcecao = $this->permissaoDeExcecaoService->findByUuid($args['uuid'], $payloadUsuarioLogado);
        if (!$permissaoDeExcecao) return $response->withStatus(404);

        $response->getBody()->write(json_encode($permissaoDeExcecao));
        return $response->withStatus(200);
    }

    public function create(Request $request, Response $response)
    {        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
            'interno' => false
        ];
        $data = (array)$request->getParsedBody(); 
        $permissaoDeExcecao = $this->permissaoDeExcecaoService->create($data, $payloadUsuarioLogado);

        $response->getBody()->write(json_encode($permissaoDeExcecao));
        return $response->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args)
    {        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
            'interno' => false
        ];
        $data = (array)$request->getParsedBody(); 
        $permissaoDeExcecao = $this->permissaoDeExcecaoService->update($args['uuid'], $data, $payloadUsuarioLogado);

        $response->getBody()->write(json_encode($permissaoDeExcecao));
        return $response->withStatus(200);
    }

    public function delete(Request $request, Response $response, array $args){ 
                $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
            'interno' => false
        ];   
        $this->permissaoDeExcecaoService->delete($args['uuid'], $payloadUsuarioLogado);
        
        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

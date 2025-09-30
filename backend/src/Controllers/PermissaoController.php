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
                        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
            'interno' => false
        ];
        $permicoes = $this->permissaoService->findAllWhere($payloadUsuarioLogado);
        $response->getBody()->write(json_encode($permicoes));
        return $response->withStatus(200);
    }

    public function get(Request $request, Response $response, array $args)
    {
                        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
            'interno' => false
        ];

        $permissao = $this->permissaoService->findByUuid($args['uuid'], $payloadUsuarioLogado);
        if (!$permissao) return $response->withStatus(404);

        $response->getBody()->write(json_encode($permissao));
        return $response->withStatus(200);
    }

    public function create(Request $request, Response $response)
    {
                        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
            'interno' => false
        ];
        
        $data = (array)$request->getParsedBody();
        $permissao = $this->permissaoService->create($data, $payloadUsuarioLogado);

        $response->getBody()->write(json_encode($permissao));
        return $response->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args)
    {
                        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
            'interno' => false
        ];
        
        $data = (array)$request->getParsedBody();
        $permissao = $this->permissaoService->update($args['uuid'], $data, $payloadUsuarioLogado);

        $response->getBody()->write(json_encode($permissao));
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
        $this->permissaoService->delete($args['uuid'], $payloadUsuarioLogado);
        
        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

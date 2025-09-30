<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\PermissaoDoUsuarioService;

class PermissaoDoUsuarioController
{
    protected PermissaoDoUsuarioService $permissaoDoUsuarioService;

    public function __construct(PermissaoDoUsuarioService $permissaoDoUsuarioService)
    {
        $this->permissaoDoUsuarioService = $permissaoDoUsuarioService;
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

        $permissoes = $this->permissaoDoUsuarioService->findByUuid($args['uuid'], $payloadUsuarioLogado);
        if (!$permissoes) return $response->withStatus(404);

        $response->getBody()->write(json_encode($permissoes));
        return $response->withStatus(200);
    }
}

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
        $permissoes = $this->permissaoDoUsuarioService->findByUuid($args['uuid']);
        if (!$permissoes) return $response->withStatus(404);

        $response->getBody()->write(json_encode($permissoes));
        return $response->withStatus(200);
    }
}

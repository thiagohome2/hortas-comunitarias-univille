<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\PermissaoDeCargoService;

class PermissaoDeCargoController
{
    protected PermissaoDeCargoService $permissaoDeCargoService;

    public function __construct(PermissaoDeCargoService $permissaoDeCargoService)
    {
        $this->permissaoDeCargoService = $permissaoDeCargoService;
    }

    
    public function list(Request $request, Response $response)
    {
        $permicoesDeCargo = $this->permissaoDeCargoService->findAllWhere();
        $response->getBody()->write(json_encode($permicoesDeCargo));
        return $response->withStatus(200);
    }

    public function get(Request $request, Response $response, array $args)
    {
        $permissaoDeCargo = $this->permissaoDeCargoService->findByUuid($args['uuid']);
        if (!$permissaoDeCargo) return $response->withStatus(404);

        $response->getBody()->write(json_encode($permissaoDeCargo));
        return $response->withStatus(200);
    }
    public function getByCargo(Request $request, Response $response, array $args)
    {
        $permissoesDeCargo = $this->permissaoDeCargoService->findByCargoUuid($args['uuid']);
        if ($permissoesDeCargo->isEmpty()) return $response->withStatus(404);

        $response->getBody()->write(json_encode($permissoesDeCargo));
        return $response->withStatus(200);
    }

    public function create(Request $request, Response $response)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $permissaoDeCargo = $this->permissaoDeCargoService->create($data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($permissaoDeCargo));
        return $response->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $permissaoDeCargo = $this->permissaoDeCargoService->update($args['uuid'], $data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($permissaoDeCargo));
        return $response->withStatus(200);
    }

    public function delete(Request $request, Response $response, array $args){   
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $this->permissaoDeCargoService->delete($args['uuid'], $uuidUsuarioLogado);
        
        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

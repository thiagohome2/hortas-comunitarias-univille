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
        
        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
            'interno' => false
        ];
        $permicoesDeCargo = $this->permissaoDeCargoService->findAllWhere($payloadUsuarioLogado);
        $response->getBody()->write(json_encode($permicoesDeCargo));
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
        $permissaoDeCargo = $this->permissaoDeCargoService->findByUuid($args['uuid'], $payloadUsuarioLogado);
        if (!$permissaoDeCargo) return $response->withStatus(404);

        $response->getBody()->write(json_encode($permissaoDeCargo));
        return $response->withStatus(200);
    }
    public function getByCargo(Request $request, Response $response, array $args)
    {
        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
            'interno' => false
        ];
        $permissoesDeCargo = $this->permissaoDeCargoService->findByCargoUuid($args['uuid'], $payloadUsuarioLogado);
        if ($permissoesDeCargo->isEmpty()) return $response->withStatus(404);

        $response->getBody()->write(json_encode($permissoesDeCargo));
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
        $permissaoDeCargo = $this->permissaoDeCargoService->create($data, $payloadUsuarioLogado);

        $response->getBody()->write(json_encode($permissaoDeCargo));
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
        $permissaoDeCargo = $this->permissaoDeCargoService->update($args['uuid'], $data, $payloadUsuarioLogado);

        $response->getBody()->write(json_encode($permissaoDeCargo));
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
        $this->permissaoDeCargoService->delete($args['uuid'], $payloadUsuarioLogado);
        
        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

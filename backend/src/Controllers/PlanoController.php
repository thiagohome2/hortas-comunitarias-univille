<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\PlanoService;

class PlanoController
{
    protected PlanoService $planoService;

    public function __construct(PlanoService $planoService)
    {
        $this->planoService = $planoService;
    }

    public function list(Request $request, Response $response)
    {                $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        $planos = $this->planoService->findAllWhere($payloadUsuarioLogado);
        $response->getBody()->write(json_encode($planos));
        return $response->withStatus(200);
    }

    public function get(Request $request, Response $response, array $args)
    {                $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        $plano = $this->planoService->findByUuid($args['uuid'], $payloadUsuarioLogado);
        if (!$plano) return $response->withStatus(404);

        $response->getBody()->write(json_encode($plano));
        return $response->withStatus(200);
    }

    public function getByUsuario(Request $request, Response $response, array $args)
    {                $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        $plano = $this->planoService->findByUsuarioUuid($args['uuid'],$payloadUsuarioLogado);
        if (!$plano) return $response->withStatus(404);

        $response->getBody()->write(json_encode($plano));
        return $response->withStatus(200);
    }

    public function create(Request $request, Response $response)
    {                $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $plano = $this->planoService->create($data, $payloadUsuarioLogado);

        $response->getBody()->write(json_encode($plano));
        return $response->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args)
    {                $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $plano = $this->planoService->update($args['uuid'], $data, $payloadUsuarioLogado);

        $response->getBody()->write(json_encode($plano));
        return $response->withStatus(200);
    }

    public function delete(Request $request, Response $response, array $args){   
                        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $this->planoService->delete($args['uuid'], $payloadUsuarioLogado);
        
        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

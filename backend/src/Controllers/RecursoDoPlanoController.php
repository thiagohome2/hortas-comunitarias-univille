<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\RecursoDoPlanoService;

class RecursoDoPlanoController
{
    protected RecursoDoPlanoService $recursoDoPlanoService;

    public function __construct(RecursoDoPlanoService $recursoDoPlanoService)
    {
        $this->recursoDoPlanoService = $recursoDoPlanoService;
    }

    public function list(Request $request, Response $response)
    {
        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        $recursosDoPlano = $this->recursoDoPlanoService->findAllWhere($payloadUsuarioLogado);
        $response->getBody()->write(json_encode($recursosDoPlano));
        return $response->withStatus(200);
    }

    public function get(Request $request, Response $response, array $args)
    {
        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        $recursoDoPlano = $this->recursoDoPlanoService->findByUuid($args['uuid'], $payloadUsuarioLogado);
        if (!$recursoDoPlano) return $response->withStatus(404);

        $response->getBody()->write(json_encode($recursoDoPlano));
        return $response->withStatus(200);
    }

    public function getByPlano(Request $request, Response $response, array $args)
    {
        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        $recursosDestePlano = $this->recursoDoPlanoService->findByPlanoUuid($args['uuid'], $payloadUsuarioLogado);
        if (!$recursosDestePlano) return $response->withStatus(404);

        $response->getBody()->write(json_encode($recursosDestePlano));
        return $response->withStatus(200);
    }

    public function create(Request $request, Response $response)
    {
        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        $data = (array)$request->getParsedBody(); 
        $recursoDoPlano = $this->recursoDoPlanoService->create($data, $payloadUsuarioLogado);

        $response->getBody()->write(json_encode($recursoDoPlano));
        return $response->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        $data = (array)$request->getParsedBody(); 
        $recursoDoPlano = $this->recursoDoPlanoService->update($args['uuid'], $data, $payloadUsuarioLogado);

        $response->getBody()->write(json_encode($recursoDoPlano));
        return $response->withStatus(200);
    }

    public function delete(Request $request, Response $response, array $args){ 
        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];   
        $this->recursoDoPlanoService->delete($args['uuid'], $payloadUsuarioLogado);
        
        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

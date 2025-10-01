<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\FinanceiroDaHortaService;

class FinanceiroDaHortaController
{
    protected FinanceiroDaHortaService $financeiroDaHortaService;

    public function __construct(FinanceiroDaHortaService $financeiroDaHortaService)
    {
        $this->financeiroDaHortaService = $financeiroDaHortaService;
    }

    public function list(Request $request, Response $response)
    {
        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        $financeirosDaHorta = $this->financeiroDaHortaService->findAllWhere($payloadUsuarioLogado);
        $response->getBody()->write(json_encode($financeirosDaHorta));
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
        $financeiroDaHorta = $this->financeiroDaHortaService->findByUuid($args['uuid'], $payloadUsuarioLogado);
        if (!$financeiroDaHorta) return $response->withStatus(404);

        $response->getBody()->write(json_encode($financeiroDaHorta));
        return $response->withStatus(200);
    }

    public function getByHorta(Request $request, Response $response, array $args)
    {
        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        $financeirosDaHorta = $this->financeiroDaHortaService->findByHortaUuid($args['uuid'], $payloadUsuarioLogado);
        if ($financeirosDaHorta->isEmpty()) return $response->withStatus(404);

        $response->getBody()->write(json_encode($financeirosDaHorta));
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
        $financeiroDaHorta = $this->financeiroDaHortaService->create($data, $payloadUsuarioLogado);

        $response->getBody()->write(json_encode($financeiroDaHorta));
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
        $financeiroDaHorta = $this->financeiroDaHortaService->update($args['uuid'], $data, $payloadUsuarioLogado);

        $response->getBody()->write(json_encode($financeiroDaHorta));
        return $response->withStatus(200);
    }

    public function delete(Request $request, Response $response, array $args){  
        
        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];  
        $this->financeiroDaHortaService->delete($args['uuid'], $payloadUsuarioLogado);
        
        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

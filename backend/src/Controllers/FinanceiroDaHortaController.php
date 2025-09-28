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
        $financeirosDaHorta = $this->financeiroDaHortaService->findAllWhere();
        $response->getBody()->write(json_encode($financeirosDaHorta));
        return $response->withStatus(200);
    }

    public function get(Request $request, Response $response, array $args)
    {
        $financeiroDaHorta = $this->financeiroDaHortaService->findByUuid($args['uuid']);
        if (!$financeiroDaHorta) return $response->withStatus(404);

        $response->getBody()->write(json_encode($financeiroDaHorta));
        return $response->withStatus(200);
    }

    public function getByHorta(Request $request, Response $response, array $args)
    {
        $financeirosDaHorta = $this->financeiroDaHortaService->findByHortaUuid($args['uuid']);
        if ($financeirosDaHorta->isEmpty()) return $response->withStatus(404);

        $response->getBody()->write(json_encode($financeirosDaHorta));
        return $response->withStatus(200);
    }

    public function create(Request $request, Response $response)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $financeiroDaHorta = $this->financeiroDaHortaService->create($data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($financeiroDaHorta));
        return $response->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $financeiroDaHorta = $this->financeiroDaHortaService->update($args['uuid'], $data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($financeiroDaHorta));
        return $response->withStatus(200);
    }

    public function delete(Request $request, Response $response, array $args){   
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $this->financeiroDaHortaService->delete($args['uuid'], $uuidUsuarioLogado);
        
        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

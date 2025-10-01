<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\CategoriaFinanceiraService;

class CategoriaFinanceiraController
{
    protected CategoriaFinanceiraService $categoriaFinanceiraService;

    public function __construct(CategoriaFinanceiraService $categoriaFinanceiraService)
    {
        $this->categoriaFinanceiraService = $categoriaFinanceiraService;
    }

    public function list(Request $request, Response $response)
    {
        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        $categoriasFinanceiras = $this->categoriaFinanceiraService->findAllWhere($payloadUsuarioLogado);
        $response->getBody()->write(json_encode($categoriasFinanceiras));
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
        $categoriaFinanceira = $this->categoriaFinanceiraService->findByUuid($args['uuid'], $payloadUsuarioLogado);
        if (!$categoriaFinanceira) return $response->withStatus(404);

        $response->getBody()->write(json_encode($categoriaFinanceira));
        return $response->withStatus(200);
    }

    public function getByAssociacao(Request $request, Response $response, array $args)
    {
        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        $categoriasFinanceirasDaAssociacao = $this->categoriaFinanceiraService->findByAssociacaoUuid($args['uuid'], $payloadUsuarioLogado);
        if ($categoriasFinanceirasDaAssociacao->isEmpty()) return $response->withStatus(404);

        $response->getBody()->write(json_encode($categoriasFinanceirasDaAssociacao));
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
        $categoriasFinanceirasDaHorta = $this->categoriaFinanceiraService->findByHortaUuid($args['uuid'], $payloadUsuarioLogado);
        if ($categoriasFinanceirasDaHorta->isEmpty()) return $response->withStatus(404);

        $response->getBody()->write(json_encode($categoriasFinanceirasDaHorta));
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
        $categoriaFinanceira = $this->categoriaFinanceiraService->create($data, $payloadUsuarioLogado);

        $response->getBody()->write(json_encode($categoriaFinanceira));
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
        $categoriaFinanceira = $this->categoriaFinanceiraService->update($args['uuid'], $data, $payloadUsuarioLogado);

        $response->getBody()->write(json_encode($categoriaFinanceira));
        return $response->withStatus(200);
    }

    public function delete(Request $request, Response $response, array $args)
    {
        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];    
        $this->categoriaFinanceiraService->delete($args['uuid'], $payloadUsuarioLogado);
        
        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

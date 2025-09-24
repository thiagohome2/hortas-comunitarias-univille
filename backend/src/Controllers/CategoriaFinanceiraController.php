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
        $categoriasFinanceiras = $this->categoriaFinanceiraService->findAllWhere();
        $response->getBody()->write(json_encode($categoriasFinanceiras));
        return $response->withStatus(200);
    }

    public function get(Request $request, Response $response, array $args)
    {
        $categoriaFinanceira = $this->categoriaFinanceiraService->findByUuid($args['uuid']);
        if (!$categoriaFinanceira) return $response->withStatus(404);

        $response->getBody()->write(json_encode($categoriaFinanceira));
        return $response->withStatus(200);
    }

    public function create(Request $request, Response $response)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $categoriaFinanceira = $this->categoriaFinanceiraService->create($data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($categoriaFinanceira));
        return $response->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $categoriaFinanceira = $this->categoriaFinanceiraService->update($args['uuid'], $data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($categoriaFinanceira));
        return $response->withStatus(200);
    }

    public function delete(Request $request, Response $response, array $args){   
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $this->categoriaFinanceiraService->delete($args['uuid'], $uuidUsuarioLogado);
        
        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

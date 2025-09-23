<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\EnderecoService;

class EnderecoController
{
    protected EnderecoService $enderecoService;

    public function __construct(EnderecoService $enderecoService)
    {
        $this->enderecoService = $enderecoService;
    }

    public function list(Request $request, Response $response)
    {
        $enderecos = $this->enderecoService->findAllWhere();
        $response->getBody()->write(json_encode($enderecos));
        return $response->withStatus(200);
    }

    public function get(Request $request, Response $response, array $args)
    {
        $endereco = $this->enderecoService->findByUuid($args['uuid']);
        if (!$endereco) return $response->withStatus(404);

        $response->getBody()->write(json_encode($endereco));
        return $response->withStatus(200);
    }

    public function create(Request $request, Response $response)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $endereco = $this->enderecoService->create($data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($endereco));
        return $response->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $endereco = $this->enderecoService->update($args['uuid'], $data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($endereco));
        return $response->withStatus(200);
    }

    public function delete(Request $request, Response $response, array $args){   
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $this->enderecoService->delete($args['uuid'], $uuidUsuarioLogado);
        
        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

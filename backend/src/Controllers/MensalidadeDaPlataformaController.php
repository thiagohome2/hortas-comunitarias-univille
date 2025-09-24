<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\MensalidadeDaPlataformaService;

class MensalidadeDaPlataformaController
{
    protected MensalidadeDaPlataformaService $mensalidadeDaPlataformaService;

    public function __construct(MensalidadeDaPlataformaService $mensalidadeDaPlataformaService)
    {
        $this->mensalidadeDaPlataformaService = $mensalidadeDaPlataformaService;
    }

    public function list(Request $request, Response $response)
    {
        $mensalidadesDaPlataforma = $this->mensalidadeDaPlataformaService->findAllWhere();
        $response->getBody()->write(json_encode($mensalidadesDaPlataforma));
        return $response->withStatus(200);
    }

    public function get(Request $request, Response $response, array $args)
    {
        $mensalidadeDaPlataforma = $this->mensalidadeDaPlataformaService->findByUuid($args['uuid']);
        if (!$mensalidadeDaPlataforma) return $response->withStatus(404);

        $response->getBody()->write(json_encode($mensalidadeDaPlataforma));
        return $response->withStatus(200);
    }

    public function create(Request $request, Response $response)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $mensalidadeDaPlataforma = $this->mensalidadeDaPlataformaService->create($data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($mensalidadeDaPlataforma));
        return $response->withStatus(201);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $data = (array)$request->getParsedBody();
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $mensalidadeDaPlataforma = $this->mensalidadeDaPlataformaService->update($args['uuid'], $data, $uuidUsuarioLogado);

        $response->getBody()->write(json_encode($mensalidadeDaPlataforma));
        return $response->withStatus(200);
    }

    public function delete(Request $request, Response $response, array $args){   
        $uuidUsuarioLogado = $request->getAttribute('usuario_uuid');
        $this->mensalidadeDaPlataformaService->delete($args['uuid'], $uuidUsuarioLogado);
        
        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

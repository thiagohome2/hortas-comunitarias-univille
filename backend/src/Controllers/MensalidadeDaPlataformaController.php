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
    {                $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        $mensalidadesDaPlataforma = $this->mensalidadeDaPlataformaService->findAllWhere($payloadUsuarioLogado);
        $response->getBody()->write(json_encode($mensalidadesDaPlataforma));
        return $response->withStatus(200);
    }

    public function get(Request $request, Response $response, array $args)
    {                $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        $mensalidadeDaPlataforma = $this->mensalidadeDaPlataformaService->findByUuid($args['uuid'], $payloadUsuarioLogado);
        if (!$mensalidadeDaPlataforma) return $response->withStatus(404);

        $response->getBody()->write(json_encode($mensalidadeDaPlataforma));
        return $response->withStatus(200);
    }

    public function getByUsuario(Request $request, Response $response, array $args)
    {                $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        $mensalidadesDaPlataforma = $this->mensalidadeDaPlataformaService->findByUsuarioUuid($args['uuid'], $payloadUsuarioLogado);
        if ($mensalidadesDaPlataforma->isEmpty()) return $response->withStatus(404);

        $response->getBody()->write(json_encode($mensalidadesDaPlataforma));
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
        $mensalidadeDaPlataforma = $this->mensalidadeDaPlataformaService->create($data, $payloadUsuarioLogado);

        $response->getBody()->write(json_encode($mensalidadeDaPlataforma));
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
        $mensalidadeDaPlataforma = $this->mensalidadeDaPlataformaService->update($args['uuid'], $data, $payloadUsuarioLogado);

        $response->getBody()->write(json_encode($mensalidadeDaPlataforma));
        return $response->withStatus(200);
    }

    public function delete(Request $request, Response $response, array $args){  
                        $payloadUsuarioLogado = [
            'usuario_uuid' => $request->getAttribute('usuario_uuid'),
            'cargo_uuid' => $request->getAttribute('cargo_uuid'),
            'associacao_uuid' => $request->getAttribute('associacao_uuid'),
            'horta_uuid' => $request->getAttribute('horta_uuid'),
        ];
        $this->mensalidadeDaPlataformaService->delete($args['uuid'], $payloadUsuarioLogado);
        
        $response->getBody()->write(json_encode([
            "message" => "Registro UUID: " . $args['uuid'] . " excluído"
        ]));
        return $response->withStatus(200);
    }
}

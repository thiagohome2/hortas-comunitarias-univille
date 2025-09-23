<?php
namespace App\Controllers;

use App\Services\SessaoService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SessaoController
{
    public function __construct(private SessaoService $service){}

    public function login(Request $request, Response $response)
    {
        $data = (array)$request->getParsedBody();

        try {
            $token = $this->service->login($data['email'] ?? '', $data['senha'] ?? '');
            $response->getBody()->write(json_encode(['token' => $token]));
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(401);
        }

        return $response->withHeader('Content-Type', 'application/json');
    }
}

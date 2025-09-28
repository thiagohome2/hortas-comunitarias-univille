<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {

        $uri = $request->getUri()->getPath();
        if ($uri === '/api/v1/sessoes' && $request->getMethod() === 'POST') {
            return $handler->handle($request);
        }


        $response = new Response();

        $authHeader = $request->getHeaderLine('Authorization');
        if (!$authHeader || !preg_match('/Bearer\s+(.*)$/i', $authHeader, $matches)) {
            $response->getBody()->write(json_encode(['error' => 'Token ausente']));
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
        }

        $token = $matches[1];

        try {
            // Decodifica o JWT usando a chave do .env
            $decoded = JWT::decode($token, new Key($_ENV['JWT_SECRET'], 'HS256'));

            // Adiciona informações do usuário logado à request
            $request = $request->withAttribute('usuario_uuid', $decoded->usuario_uuid ?? null)
                               ->withAttribute('cargo_uuid', $decoded->cargo_uuid ?? null);

        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => 'Token inválido', 'message' => $e->getMessage()]));
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
        }

        return $handler->handle($request);
    }
}

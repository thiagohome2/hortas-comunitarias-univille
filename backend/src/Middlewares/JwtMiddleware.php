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
        $method = $request->getMethod();

        // Apenas estas rotas públicas
        $publicRoutes = [
            '/api/v1/sessoes/login POST',
            '/api/v1/sessoes/cadastro POST',
        ];

        $routeKey = $uri . ' ' . $method;

        // Rota pública: permite passar sem JWT
        if (in_array($routeKey, $publicRoutes, true)) {
            // Se não houver JWT, setar NEW_ACCOUNT
            $usuarioUuid = $request->getAttribute('usuario_uuid');
            if (!$usuarioUuid) {
                $request = $request->withAttribute('usuario_uuid', 'NEW_ACCOUNT');
            }
            return $handler->handle($request);
        }

        // A partir daqui, exige token
        $response = new Response();
        $authHeader = $request->getHeaderLine('Authorization');

        if (!$authHeader || !preg_match('/Bearer\s+(.*)$/i', $authHeader, $matches)) {
            $response->getBody()->write(json_encode(['error' => 'Token ausente']));
            return $response->withStatus(401);
        }

        $token = $matches[1];

        try {
            $decoded = JWT::decode($token, new Key($_ENV['JWT_SECRET'], 'HS256'));

            // Adiciona informações do usuário logado à request
            $request = $request
                ->withAttribute('usuario_uuid', $decoded->usuario_uuid ?? null)
                ->withAttribute('cargo_uuid', $decoded->cargo_uuid ?? null)
                ->withAttribute('associacao_uuid', $decoded->associacao_uuid ?? null)
                ->withAttribute('horta_uuid', $decoded->horta_uuid ?? null);

        } catch (\Exception $e) {
            $response->getBody()->write(json_encode([
                'error' => 'Token inválido',
                'message' => $e->getMessage()
            ]));
            return $response->withStatus(401);
        }

        return $handler->handle($request);
    }
}

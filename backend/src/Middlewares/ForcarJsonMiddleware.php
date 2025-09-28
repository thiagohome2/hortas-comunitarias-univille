<?php
namespace App\Middlewares;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class ForcarJsonMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);

        // Se o body já for JSON, não faz nada
        $conteudo = (string) $response->getBody();
        $json = json_decode($conteudo, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            // Se não era JSON, embala num JSON
            $conteudo = json_encode(['data' => $conteudo], JSON_UNESCAPED_UNICODE);
            $response->getBody()->rewind();
            $response->getBody()->write($conteudo);
        }

        return $response->withHeader('Content-Type', 'application/json');
    }
}

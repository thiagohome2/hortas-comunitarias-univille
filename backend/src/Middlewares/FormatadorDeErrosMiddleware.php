<?php

namespace App\Middlewares;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Respect\Validation\Exceptions\NestedValidationException;
use Slim\Exception\HttpException;
use Throwable;

class FormatadorDeErrosMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        try {
            return $handler->handle($request);
        } catch (NestedValidationException $e) {
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write(json_encode([
                'error' => 'Erro de validação de campos',
                'details' => $e->getMessages(),
                'status' => 422
            ], JSON_UNESCAPED_UNICODE));
            return $response->withHeader('Content-Type', 'application/json')
                ->withStatus(422);
        } catch (HttpException $e) {
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write(json_encode([
                'error' => $e->getMessage(),
                'status' => $e->getCode()
            ], JSON_UNESCAPED_UNICODE));
            return $response->withHeader('Content-Type', 'application/json')
                ->withStatus($e->getCode());
        } catch (Throwable $e) {
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write(json_encode([
                'error' => $e->getMessage(),
                'status' => 500
            ], JSON_UNESCAPED_UNICODE));
            return $response->withHeader('Content-Type', 'application/json')
                ->withStatus(500);
        }
    }
}

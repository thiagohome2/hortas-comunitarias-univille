<?php

use App\Controllers\EnderecoController;
use App\Middlewares\JwtMiddleware;
use Slim\Routing\RouteCollectorProxy;

return function (RouteCollectorProxy $app) {
    $jwtMiddleware = new JwtMiddleware();

    $app->group('/enderecos', function (RouteCollectorProxy $group) {
        $group->get('', EnderecoController::class . ':list');
        $group->get('/{uuid}', EnderecoController::class . ':get');
        $group->post('', EnderecoController::class . ':create');
        $group->put('/{uuid}', EnderecoController::class . ':update');
        $group->delete('/{uuid}', EnderecoController::class . ':delete');
    })->add($jwtMiddleware);
};

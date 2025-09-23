<?php

use App\Controllers\AssociacaoController;
use App\Middlewares\JwtMiddleware;
use Slim\Routing\RouteCollectorProxy;

return function (RouteCollectorProxy $app) {
    $jwtMiddleware = new JwtMiddleware();

    $app->group('/associacoes', function (RouteCollectorProxy $group) {
        $group->get('', AssociacaoController::class . ':list');
        $group->get('/{uuid}', AssociacaoController::class . ':get');
        $group->post('', AssociacaoController::class . ':create');
        $group->put('/{uuid}', AssociacaoController::class . ':update');
        $group->delete('/{uuid}', AssociacaoController::class . ':delete');
    })->add($jwtMiddleware);
};

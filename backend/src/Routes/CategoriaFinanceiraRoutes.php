<?php

use App\Controllers\CategoriaFinanceiraController;
use App\Middlewares\JwtMiddleware;
use Slim\Routing\RouteCollectorProxy;

// TODO: /horta/uuid, /associacao/uuid

return function (RouteCollectorProxy $app) {
    $jwtMiddleware = new JwtMiddleware();

    $app->group('/categoria-financeira', function (RouteCollectorProxy $group) {
        $group->get('', CategoriaFinanceiraController::class . ':list');
        $group->get('/{uuid}', CategoriaFinanceiraController::class . ':get');
        $group->post('', CategoriaFinanceiraController::class . ':create');
        $group->put('/{uuid}', CategoriaFinanceiraController::class . ':update');
        $group->delete('/{uuid}', CategoriaFinanceiraController::class . ':delete');
    })->add($jwtMiddleware);
};

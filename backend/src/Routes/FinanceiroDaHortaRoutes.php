<?php

use App\Controllers\FinanceiroDaHortaController;
use App\Middlewares\JwtMiddleware;
use Slim\Routing\RouteCollectorProxy;

return function (RouteCollectorProxy $app) {
    $jwtMiddleware = new JwtMiddleware();

    $app->group('/financeiro-da-horta', function (RouteCollectorProxy $group) {
        $group->get('', FinanceiroDaHortaController::class . ':list');
        $group->get('/{uuid}', FinanceiroDaHortaController::class . ':get');
        $group->post('', FinanceiroDaHortaController::class . ':create');
        $group->put('/{uuid}', FinanceiroDaHortaController::class . ':update');
        $group->delete('/{uuid}', FinanceiroDaHortaController::class . ':delete');
    })->add($jwtMiddleware);
};

<?php

use App\Controllers\RecursoDoPlanoController;
use App\Middlewares\JwtMiddleware;
use Slim\Routing\RouteCollectorProxy;

return function (RouteCollectorProxy $app) {
    $jwtMiddleware = new JwtMiddleware();

    $app->group('/recursos-do-plano', function (RouteCollectorProxy $group) {
        $group->get('', RecursoDoPlanoController::class . ':list');
        $group->get('/{uuid}', RecursoDoPlanoController::class . ':get');
        $group->post('', RecursoDoPlanoController::class . ':create');
        $group->put('/{uuid}', RecursoDoPlanoController::class . ':update');
        $group->delete('/{uuid}', RecursoDoPlanoController::class . ':delete');
    })->add($jwtMiddleware);
};

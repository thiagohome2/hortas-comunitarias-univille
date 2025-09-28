<?php

use App\Controllers\RecursoDoPlanoController;
use Slim\Routing\RouteCollectorProxy;

return function (RouteCollectorProxy $app) { 
    $app->group('/recursos-do-plano', function (RouteCollectorProxy $group) {
        $group->get('', RecursoDoPlanoController::class . ':list');
        $group->get('/{uuid}', RecursoDoPlanoController::class . ':get');
        $group->get('/plano/{uuid}', RecursoDoPlanoController::class . ':getByPlano');
        $group->post('', RecursoDoPlanoController::class . ':create');
        $group->put('/{uuid}', RecursoDoPlanoController::class . ':update');
        $group->delete('/{uuid}', RecursoDoPlanoController::class . ':delete');});
};

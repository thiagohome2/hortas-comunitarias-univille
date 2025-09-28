<?php

use App\Controllers\CategoriaFinanceiraController;
use Slim\Routing\RouteCollectorProxy;

// TODO: /horta/uuid, /associacao/uuid

return function (RouteCollectorProxy $app) {
    $app->group('/categorias-financeiras', function (RouteCollectorProxy $group) {
        $group->get('', CategoriaFinanceiraController::class . ':list');
        $group->get('/{uuid}', CategoriaFinanceiraController::class . ':get');
        $group->get('/associacao/{uuid}', CategoriaFinanceiraController::class . ':getByAssociacao');
        $group->get('/horta/{uuid}', CategoriaFinanceiraController::class . ':getByHorta');
        $group->post('', CategoriaFinanceiraController::class . ':create');
        $group->put('/{uuid}', CategoriaFinanceiraController::class . ':update');
        $group->delete('/{uuid}', CategoriaFinanceiraController::class . ':delete');});
};

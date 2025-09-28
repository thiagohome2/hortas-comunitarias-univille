<?php

use App\Controllers\AssociacaoController;
use Slim\Routing\RouteCollectorProxy;

return function (RouteCollectorProxy $app) {
    $app->group('/associacoes', function (RouteCollectorProxy $group) {
        $group->get('', AssociacaoController::class . ':list');
        $group->get('/{uuid}', AssociacaoController::class . ':get');
        $group->post('', AssociacaoController::class . ':create');
        $group->put('/{uuid}', AssociacaoController::class . ':update');
        $group->delete('/{uuid}', AssociacaoController::class . ':delete');});
};

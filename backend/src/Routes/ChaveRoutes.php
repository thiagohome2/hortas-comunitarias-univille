<?php

use App\Controllers\ChaveController;
use Slim\Routing\RouteCollectorProxy;

return function (RouteCollectorProxy $app) {
    $app->group('/chaves', function (RouteCollectorProxy $group) {
        $group->get('', ChaveController::class . ':list');
        $group->get('/{uuid}', ChaveController::class . ':get');
        $group->post('', ChaveController::class . ':create');
        $group->put('/{uuid}', ChaveController::class . ':update');
        $group->delete('/{uuid}', ChaveController::class . ':delete');});
};

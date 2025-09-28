<?php

use App\Controllers\HortaController;
use Slim\Routing\RouteCollectorProxy;

return function (RouteCollectorProxy $app) { 
    $app->group('/hortas', function (RouteCollectorProxy $group) {
        $group->get('', HortaController::class . ':list');
        $group->get('/{uuid}', HortaController::class . ':get');
        $group->post('', HortaController::class . ':create');
        $group->put('/{uuid}', HortaController::class . ':update');
        $group->delete('/{uuid}', HortaController::class . ':delete');});
};

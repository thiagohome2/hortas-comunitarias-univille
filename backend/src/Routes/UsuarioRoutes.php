<?php

use App\Controllers\UsuarioController;
use Slim\Routing\RouteCollectorProxy;

return function (RouteCollectorProxy $app) { 
    $app->group('/usuarios', function (RouteCollectorProxy $group) {
        $group->get('', UsuarioController::class . ':list');
        $group->get('/{uuid}', UsuarioController::class . ':get');
        $group->post('', UsuarioController::class . ':create');
        $group->put('/{uuid}', UsuarioController::class . ':update');
        $group->delete('/{uuid}', UsuarioController::class . ':delete');});
};

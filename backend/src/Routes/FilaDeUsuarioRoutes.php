<?php

use App\Controllers\FilaDeUsuarioController;
use Slim\Routing\RouteCollectorProxy;

return function (RouteCollectorProxy $app) {
    $app->group('/fila-de-usuarios', function (RouteCollectorProxy $group) {
        $group->get('', FilaDeUsuarioController::class . ':list');
        $group->get('/{uuid}', FilaDeUsuarioController::class . ':get');
        $group->get('/horta/{uuid}', FilaDeUsuarioController::class . ':getByHorta');
        $group->get('/usuario/{uuid}', FilaDeUsuarioController::class . ':getByUsuario');
        $group->post('', FilaDeUsuarioController::class . ':create');
        $group->put('/{uuid}', FilaDeUsuarioController::class . ':update');
        $group->delete('/{uuid}', FilaDeUsuarioController::class . ':delete');}); 
};

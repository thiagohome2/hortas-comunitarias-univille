<?php

use App\Controllers\MensalidadeDaAssociacaoController;
use App\Middlewares\JwtMiddleware;
use Slim\Routing\RouteCollectorProxy;

return function (RouteCollectorProxy $app) {
    $jwtMiddleware = new JwtMiddleware();

    $app->group('/mensalidades-da-associacao', function (RouteCollectorProxy $group) {
        $group->get('', MensalidadeDaAssociacaoController::class . ':list');
        $group->get('/{uuid}', MensalidadeDaAssociacaoController::class . ':get');
        $group->get('/associacao/{uuid}', MensalidadeDaAssociacaoController::class . ':getByAssociacao');
        $group->get('/usuario/{uuid}', MensalidadeDaAssociacaoController::class . ':getByUsuario');
        $group->post('', MensalidadeDaAssociacaoController::class . ':create');
        $group->put('/{uuid}', MensalidadeDaAssociacaoController::class . ':update');
        $group->delete('/{uuid}', MensalidadeDaAssociacaoController::class . ':delete');
    })->add($jwtMiddleware);
};

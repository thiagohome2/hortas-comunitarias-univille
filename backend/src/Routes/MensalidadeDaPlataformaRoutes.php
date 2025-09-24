<?php

use App\Controllers\MensalidadeDaPlataformaController;
use App\Middlewares\JwtMiddleware;
use Slim\Routing\RouteCollectorProxy;

return function (RouteCollectorProxy $app) {
    $jwtMiddleware = new JwtMiddleware();

    $app->group('/mensalidade-da-plataforma', function (RouteCollectorProxy $group) {
        $group->get('', MensalidadeDaPlataformaController::class . ':list');
        $group->get('/{uuid}', MensalidadeDaPlataformaController::class . ':get');
        $group->post('', MensalidadeDaPlataformaController::class . ':create');
        $group->put('/{uuid}', MensalidadeDaPlataformaController::class . ':update');
        $group->delete('/{uuid}', MensalidadeDaPlataformaController::class . ':delete');
    })->add($jwtMiddleware);
};

<?php

use App\Controllers\MensalidadeDaPlataformaController;
use Slim\Routing\RouteCollectorProxy;

return function (RouteCollectorProxy $app) { 
    $app->group('/mensalidades-da-plataforma', function (RouteCollectorProxy $group) {
        $group->get('', MensalidadeDaPlataformaController::class . ':list');
        $group->get('/{uuid}', MensalidadeDaPlataformaController::class . ':get');
        $group->get('/usuario/{uuid}', MensalidadeDaPlataformaController::class . ':getByUsuario');
        $group->post('', MensalidadeDaPlataformaController::class . ':create');
        $group->put('/{uuid}', MensalidadeDaPlataformaController::class . ':update');
        $group->delete('/{uuid}', MensalidadeDaPlataformaController::class . ':delete');});
};

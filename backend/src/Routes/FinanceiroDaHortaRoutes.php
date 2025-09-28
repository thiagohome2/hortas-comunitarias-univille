<?php

use App\Controllers\FinanceiroDaHortaController;
use Slim\Routing\RouteCollectorProxy;

return function (RouteCollectorProxy $app) { 
    $app->group('/financeiro-da-horta', function (RouteCollectorProxy $group) {
        $group->get('', FinanceiroDaHortaController::class . ':list');
        $group->get('/{uuid}', FinanceiroDaHortaController::class . ':get');
        $group->get('/horta/{uuid}', FinanceiroDaHortaController::class . ':getByHorta');
        $group->post('', FinanceiroDaHortaController::class . ':create');
        $group->put('/{uuid}', FinanceiroDaHortaController::class . ':update');
        $group->delete('/{uuid}', FinanceiroDaHortaController::class . ':delete');});
};

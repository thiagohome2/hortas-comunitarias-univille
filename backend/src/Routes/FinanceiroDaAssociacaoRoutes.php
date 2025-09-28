<?php

use App\Controllers\FinanceiroDaAssociacaoController;
use Slim\Routing\RouteCollectorProxy;

return function (RouteCollectorProxy $app) { 
    $app->group('/financeiro-da-associacao', function (RouteCollectorProxy $group) {
        $group->get('', FinanceiroDaAssociacaoController::class . ':list');
        $group->get('/{uuid}', FinanceiroDaAssociacaoController::class . ':get');
        $group->get('/associacao/{uuid}', FinanceiroDaAssociacaoController::class . ':getByAssociacao');
        $group->post('', FinanceiroDaAssociacaoController::class . ':create');
        $group->put('/{uuid}', FinanceiroDaAssociacaoController::class . ':update');
        $group->delete('/{uuid}', FinanceiroDaAssociacaoController::class . ':delete');});
};

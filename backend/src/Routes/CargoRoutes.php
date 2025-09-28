<?php
 
use App\Controllers\CargoController;
use Slim\Routing\RouteCollectorProxy;

return function(RouteCollectorProxy $app){
    $app->group('/cargos', function(RouteCollectorProxy $group){
        $group->get('', CargoController::class.':list');
        $group->get('/{uuid}', CargoController::class.':get');
        $group->post('', CargoController::class.':create');
        $group->put('/{uuid}', CargoController::class.':update');
        $group->delete('/{uuid}', CargoController::class.':delete');});
};

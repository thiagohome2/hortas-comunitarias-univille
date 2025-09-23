<?php
 
use App\Controllers\CargoController;
use App\Middlewares\JwtMiddleware;
use Slim\Routing\RouteCollectorProxy;

return function(RouteCollectorProxy $app){
    $jwt = new JwtMiddleware();
    $app->group('/cargos', function(RouteCollectorProxy $group){
        $group->get('', CargoController::class.':list');
        $group->get('/{uuid}', CargoController::class.':get');
        $group->post('', CargoController::class.':create');
        $group->put('/{uuid}', CargoController::class.':update');
        $group->delete('/{uuid}', CargoController::class.':delete');
    })->add($jwt);
};

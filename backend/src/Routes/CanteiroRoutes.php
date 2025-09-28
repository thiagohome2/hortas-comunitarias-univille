<?php
 
use App\Controllers\CanteiroController;
use App\Middlewares\JwtMiddleware;
use Slim\Routing\RouteCollectorProxy;

return function(RouteCollectorProxy $app){
    $jwt = new JwtMiddleware();
    $app->group('/canteiros', function(RouteCollectorProxy $group){
        $group->get('', CanteiroController::class.':list');
        $group->get('/{uuid}', CanteiroController::class.':get');
        $group->post('', CanteiroController::class.':create');
        $group->put('/{uuid}', CanteiroController::class.':update');
        $group->delete('/{uuid}', CanteiroController::class.':delete');
    })->add($jwt);
};

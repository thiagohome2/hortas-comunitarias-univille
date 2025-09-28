<?php
 
use App\Controllers\CanteiroEUsuarioController;
use Slim\Routing\RouteCollectorProxy;

return function(RouteCollectorProxy $app){
    $app->group('/canteiros-e-usuarios', function(RouteCollectorProxy $group){
        $group->get('', CanteiroEUsuarioController::class.':list');
        $group->get('/{uuid}', CanteiroEUsuarioController::class.':get');
        $group->post('', CanteiroEUsuarioController::class.':create');
        $group->put('/{uuid}', CanteiroEUsuarioController::class.':update');
        $group->delete('/{uuid}', CanteiroEUsuarioController::class.':delete');});
};

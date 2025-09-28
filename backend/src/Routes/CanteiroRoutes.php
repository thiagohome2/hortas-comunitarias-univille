<?php
 
use App\Controllers\CanteiroController;
use Slim\Routing\RouteCollectorProxy;

return function(RouteCollectorProxy $app){
    $app->group('/canteiros', function(RouteCollectorProxy $group){
        $group->get('', CanteiroController::class.':list');
        $group->get('/{uuid}', CanteiroController::class.':get');
        $group->post('', CanteiroController::class.':create');
        $group->put('/{uuid}', CanteiroController::class.':update');
        $group->delete('/{uuid}', CanteiroController::class.':delete');});
};

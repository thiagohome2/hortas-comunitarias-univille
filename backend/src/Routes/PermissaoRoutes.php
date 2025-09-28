<?php
 
use App\Controllers\PermissaoController;
use Slim\Routing\RouteCollectorProxy;

return function(RouteCollectorProxy $app){ 
    $app->group('/permissoes', function(RouteCollectorProxy $group){
        $group->get('', PermissaoController::class.':list');
        $group->get('/{uuid}', PermissaoController::class.':get');
        $group->post('', PermissaoController::class.':create');
        $group->put('/{uuid}', PermissaoController::class.':update');
        $group->delete('/{uuid}', PermissaoController::class.':delete');});
};

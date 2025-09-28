<?php
 
use App\Controllers\PermissaoDeCargoController;
use Slim\Routing\RouteCollectorProxy;

return function(RouteCollectorProxy $app){ 
    $app->group('/permissoes-de-cargo', function(RouteCollectorProxy $group){
        $group->get('', PermissaoDeCargoController::class.':list');
        $group->get('/{uuid}', PermissaoDeCargoController::class.':get');
        $group->get('/cargo/{uuid}', PermissaoDeCargoController::class.':getByCargo');
        $group->post('', PermissaoDeCargoController::class.':create');
        $group->put('/{uuid}', PermissaoDeCargoController::class.':update');
        $group->delete('/{uuid}', PermissaoDeCargoController::class.':delete');});
};

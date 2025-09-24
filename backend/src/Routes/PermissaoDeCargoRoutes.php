<?php
 
use App\Controllers\PermissaoDeCargoController;
use App\Middlewares\JwtMiddleware;
use Slim\Routing\RouteCollectorProxy;

return function(RouteCollectorProxy $app){
    $jwt = new JwtMiddleware();
    $app->group('/permissoes-de-cargo', function(RouteCollectorProxy $group){
        $group->get('', PermissaoDeCargoController::class.':list');
        $group->get('/{uuid}', PermissaoDeCargoController::class.':get');
        $group->get('/cargo/{uuid}', PermissaoDeCargoController::class.':getByCargo');
        $group->post('', PermissaoDeCargoController::class.':create');
        $group->put('/{uuid}', PermissaoDeCargoController::class.':update');
        $group->delete('/{uuid}', PermissaoDeCargoController::class.':delete');
    })->add($jwt);
};

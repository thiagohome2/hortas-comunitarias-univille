<?php
 
use App\Controllers\PermissaoDoUsuarioController;
use App\Middlewares\JwtMiddleware;
use Slim\Routing\RouteCollectorProxy;

return function(RouteCollectorProxy $app){
    $jwt = new JwtMiddleware();
    $app->group('/permissoes-do-usuario', function(RouteCollectorProxy $group){
        $group->get('/{uuid}', PermissaoDoUsuarioController::class.':get');
    })->add($jwt);
};

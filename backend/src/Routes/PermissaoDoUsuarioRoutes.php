<?php
 
use App\Controllers\PermissaoDoUsuarioController;
use Slim\Routing\RouteCollectorProxy;

return function(RouteCollectorProxy $app){
    $app->group('/permissoes-do-usuario', function(RouteCollectorProxy $group){
        $group->get('/{uuid}', PermissaoDoUsuarioController::class.':get');});
};

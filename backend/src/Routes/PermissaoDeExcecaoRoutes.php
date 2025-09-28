<?php
 
use App\Controllers\PermissaoDeExcecaoController;
use Slim\Routing\RouteCollectorProxy;

return function(RouteCollectorProxy $app){ 
    $app->group('/permissoes-de-excecao', function(RouteCollectorProxy $group){
        $group->get('', PermissaoDeExcecaoController::class.':list');
        $group->get('/{uuid}', PermissaoDeExcecaoController::class.':get');
        $group->post('', PermissaoDeExcecaoController::class.':create');
        $group->put('/{uuid}', PermissaoDeExcecaoController::class.':update');
        $group->delete('/{uuid}', PermissaoDeExcecaoController::class.':delete');});
};

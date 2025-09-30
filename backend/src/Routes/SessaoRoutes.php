<?php
use Slim\App;
use App\Controllers\SessaoController;
use Slim\Routing\RouteCollectorProxy;

return function(RouteCollectorProxy $app){
    $app->group('/sessoes', function (RouteCollectorProxy $group) {
        $group->post('/login', SessaoController::class.':signIn');
        $group->post('/cadastro', SessaoController::class . ':signUp');});
};

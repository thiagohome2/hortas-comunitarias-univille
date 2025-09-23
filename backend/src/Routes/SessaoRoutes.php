<?php
use Slim\App;
use App\Controllers\SessaoController;
use Slim\Routing\RouteCollectorProxy;

return function(RouteCollectorProxy $app){
    $app->post('/sessao', SessaoController::class.':login');
};

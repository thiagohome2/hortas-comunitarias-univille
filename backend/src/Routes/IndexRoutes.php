<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->group('/api/v1', function (RouteCollectorProxy $group) {
        $usuarioRoutes = require __DIR__ . '/UsuarioRoutes.php';
        $usuarioRoutes($group);

        $associacaoRoutes = require __DIR__ . '/AssociacaoRoutes.php';
        $associacaoRoutes($group);

        $hortaRoutes = require __DIR__ . '/HortaRoutes.php';
        $hortaRoutes($group);

        $enderecoRoutes = require __DIR__ . '/EnderecoRoutes.php';
        $enderecoRoutes($group);
        
        $cargoRoutes = require __DIR__ . '/CargoRoutes.php';
        $cargoRoutes($group);

        $sessaoRoutes = require __DIR__ . '/SessaoRoutes.php';
        $sessaoRoutes($group);
    });
};

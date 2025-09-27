<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->group('/api/v1', function (RouteCollectorProxy $group) {
        $sessaoRoutes = require __DIR__ . '/SessaoRoutes.php';
        $sessaoRoutes($group);

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

        $canteiroRoutes = require __DIR__ . '/CanteiroRoutes.php';
        $canteiroRoutes($group);

        $canteiroEUsuarioRoutes = require __DIR__ . '/CanteiroEUsuarioRoutes.php';
        $canteiroEUsuarioRoutes($group);

        $permissaoRoutes = require __DIR__ . '/PermissaoRoutes.php';
        $permissaoRoutes($group);

        $permissaoDeCargoRoutes = require __DIR__ . '/PermissaoDeCargoRoutes.php';
        $permissaoDeCargoRoutes($group);

        $permissaoDeExcecaoRoutes = require __DIR__ . '/PermissaoDeExcecaoRoutes.php';
        $permissaoDeExcecaoRoutes($group);
 
        $permissaoDoUsuarioRoutes = require __DIR__ . '/PermissaoDoUsuarioRoutes.php';
        $permissaoDoUsuarioRoutes($group);

        $categoriaFinanceiraRoutes = require __DIR__ . '/CategoriaFinanceiraRoutes.php';
        $categoriaFinanceiraRoutes($group);

        $planoRoutes = require __DIR__ . '/PlanoRoutes.php';
        $planoRoutes($group);

        $recursoDoPlanoRoutes = require __DIR__ . '/RecursoDoPlanoRoutes.php';
        $recursoDoPlanoRoutes($group);

        $financeiroDaAssociacaoRoutes = require __DIR__ . '/FinanceiroDaAssociacaoRoutes.php';
        $financeiroDaAssociacaoRoutes($group);

        $financeiroDaHortaRoutes = require __DIR__ . '/FinanceiroDaHortaRoutes.php';
        $financeiroDaHortaRoutes($group);

        $mensalidadeDaAssociacaoRoutes = require __DIR__ . '/MensalidadeDaAssociacaoRoutes.php';
        $mensalidadeDaAssociacaoRoutes($group);

        $mensalidadeDaPlataformaRoutes = require __DIR__ . '/MensalidadeDaPlataformaRoutes.php';
        $mensalidadeDaPlataformaRoutes($group);

        $chavesRoutes = require __DIR__ . '/ChaveRoutes.php';
        $chavesRoutes($group);

        $filaDeUsuarioRoutes = require __DIR__ . '/FilaDeUsuarioRoutes.php';
        $filaDeUsuarioRoutes($group); 
    });
};

<?php

    declare(strict_types=1);

    use DI\ContainerBuilder;

    return function(ContainerBuilder $containerBuilder){
        $sessaoBindings = require __DIR__ . '/sessao_bindings.php';
        $sessaoBindings($containerBuilder);

        $database = require __DIR__ . '/database.php';
        $database($containerBuilder);
       
        $usuarioBindings = require __DIR__ . '/usuario_bindings.php';
        $usuarioBindings($containerBuilder);

        $associacaoBindings = require __DIR__ . '/associacao_bindings.php';
        $associacaoBindings($containerBuilder);
        
        $hortaBindings = require __DIR__ . '/horta_bindings.php';
        $hortaBindings($containerBuilder);

        $enderecoBindings = require __DIR__ . '/endereco_bindings.php';
        $enderecoBindings($containerBuilder);

        $cargoBindings = require __DIR__ . '/cargo_bindings.php';
        $cargoBindings($containerBuilder);

        $canteiroBindings = require __DIR__ . '/canteiro_bindings.php';
        $canteiroBindings($containerBuilder);

        $canteiroEUsuarioBindings = require __DIR__ . '/canteiro_e_usuario_bindings.php';
        $canteiroEUsuarioBindings($containerBuilder);

        $permissaoBindings = require __DIR__ . '/permissao_bindings.php';
        $permissaoBindings($containerBuilder);

        $permissaoDeCargoBindings = require __DIR__ . '/permissao_de_cargo_bindings.php';
        $permissaoDeCargoBindings($containerBuilder);

        $permissaoDeExcecaoBindings = require __DIR__ . '/permissao_de_excecao_bindings.php';
        $permissaoDeExcecaoBindings($containerBuilder);

        $permissaoDoUsuario = require __DIR__ . '/permissao_do_usuario_bindings.php';
        $permissaoDoUsuario($containerBuilder);
    }

?>
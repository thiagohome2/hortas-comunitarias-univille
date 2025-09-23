<?php

    declare(strict_types=1);

    use DI\ContainerBuilder;

    return function(ContainerBuilder $containerBuilder){
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

        $sessaoBindings = require __DIR__ . '/sessao_bindings.php';
        $sessaoBindings($containerBuilder);
    }

?>
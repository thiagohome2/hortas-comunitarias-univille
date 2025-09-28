<?php
use DI\ContainerBuilder;
use App\Models\UsuarioModel;
use App\Services\SessaoService;
use App\Controllers\SessaoController;

return function(ContainerBuilder $container){
    $container->addDefinitions([
        UsuarioModel::class => DI\autowire(UsuarioModel::class),
        SessaoService::class => DI\autowire(SessaoService::class),
        SessaoController::class => DI\autowire(SessaoController::class),
    ]);
};

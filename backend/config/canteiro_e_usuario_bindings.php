<?php
use DI\ContainerBuilder;
use App\Models\CanteiroEUsuarioModel;
use App\Repositories\CanteiroEUsuarioRepository;
use App\Services\CanteiroEUsuarioService;
use App\Controllers\CanteiroEUsuarioController;

return function(ContainerBuilder $container){
    $container->addDefinitions([
        CanteiroEUsuarioModel::class => DI\autowire(CanteiroEUsuarioModel::class),
        CanteiroEUsuarioRepository::class => DI\autowire(CanteiroEUsuarioRepository::class),
        CanteiroEUsuarioService::class => DI\autowire(CanteiroEUsuarioService::class),
        CanteiroEUsuarioController::class => DI\autowire(CanteiroEUsuarioController::class),
    ]);
};

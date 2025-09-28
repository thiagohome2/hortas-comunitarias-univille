<?php
use DI\ContainerBuilder;
use App\Models\PermissaoDeCargoModel;
use App\Repositories\PermissaoDeCargoRepository;
use App\Services\PermissaoDeCargoService;
use App\Controllers\PermissaoDeCargoController;

return function(ContainerBuilder $container){
    $container->addDefinitions([
        PermissaoDeCargoModel::class => DI\autowire(PermissaoDeCargoModel::class),
        PermissaoDeCargoRepository::class => DI\autowire(PermissaoDeCargoRepository::class),
        PermissaoDeCargoService::class => DI\autowire(PermissaoDeCargoService::class),
        PermissaoDeCargoController::class => DI\autowire(PermissaoDeCargoController::class),
    ]);
};

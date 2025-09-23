<?php
use DI\ContainerBuilder;
use App\Models\CargoModel;
use App\Repositories\CargoRepository;
use App\Services\CargoService;
use App\Controllers\CargoController;

return function(ContainerBuilder $container){
    $container->addDefinitions([
        CargoModel::class => DI\autowire(CargoModel::class),
        CargoRepository::class => DI\autowire(CargoRepository::class),
        CargoService::class => DI\autowire(CargoService::class),
        CargoController::class => DI\autowire(CargoController::class),
    ]);
};

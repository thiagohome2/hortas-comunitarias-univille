<?php
use DI\ContainerBuilder;
use App\Models\CanteiroModel;
use App\Repositories\CanteiroRepository;
use App\Services\CanteiroService;
use App\Controllers\CanteiroController;

return function(ContainerBuilder $container){
    $container->addDefinitions([
        CanteiroModel::class => DI\autowire(CanteiroModel::class),
        CanteiroRepository::class => DI\autowire(CanteiroRepository::class),
        CanteiroService::class => DI\autowire(CanteiroService::class),
        CanteiroController::class => DI\autowire(CanteiroController::class),
    ]);
};

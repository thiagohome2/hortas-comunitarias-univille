<?php

use DI\ContainerBuilder;
use App\Models\PlanoModel;
use App\Repositories\PlanoRepository;
use App\Services\PlanoService;
use App\Controllers\PlanoController;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        PlanoModel::class => DI\autowire(PlanoModel::class),
        PlanoRepository::class => DI\autowire(PlanoRepository::class),
        PlanoService::class => DI\autowire(PlanoService::class),
        PlanoController::class => DI\autowire(PlanoController::class),
    ]);
};

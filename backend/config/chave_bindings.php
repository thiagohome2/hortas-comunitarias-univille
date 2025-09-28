<?php

use DI\ContainerBuilder;
use App\Models\ChaveModel;
use App\Repositories\ChaveRepository;
use App\Services\ChaveService;
use App\Controllers\ChaveController;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        ChaveModel::class => DI\autowire(ChaveModel::class),
        ChaveRepository::class => DI\autowire(ChaveRepository::class),
        ChaveService::class => DI\autowire(ChaveService::class),
        ChaveController::class => DI\autowire(ChaveController::class),
    ]);
};

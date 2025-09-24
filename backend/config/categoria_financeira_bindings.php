<?php

use DI\ContainerBuilder;
use App\Models\CategoriaFinanceiraModel;
use App\Repositories\CategoriaFinanceiraRepository;
use App\Services\CategoriaFinanceiraService;
use App\Controllers\CategoriaFinanceiraController;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        CategoriaFinanceiraModel::class => DI\autowire(CategoriaFinanceiraModel::class),
        CategoriaFinanceiraRepository::class => DI\autowire(CategoriaFinanceiraRepository::class),
        CategoriaFinanceiraService::class => DI\autowire(CategoriaFinanceiraService::class),
        CategoriaFinanceiraController::class => DI\autowire(CategoriaFinanceiraController::class),
    ]);
};

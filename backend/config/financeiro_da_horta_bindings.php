<?php

use DI\ContainerBuilder;
use App\Models\FinanceiroDaHortaModel;
use App\Repositories\FinanceiroDaHortaRepository;
use App\Services\FinanceiroDaHortaService;
use App\Controllers\FinanceiroDaHortaController;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        FinanceiroDaHortaModel::class => DI\autowire(FinanceiroDaHortaModel::class),
        FinanceiroDaHortaRepository::class => DI\autowire(FinanceiroDaHortaRepository::class),
        FinanceiroDaHortaService::class => DI\autowire(FinanceiroDaHortaService::class),
        FinanceiroDaHortaController::class => DI\autowire(FinanceiroDaHortaController::class),
    ]);
};

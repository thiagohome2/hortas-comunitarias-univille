<?php

use DI\ContainerBuilder;
use App\Models\HortaModel;
use App\Repositories\HortaRepository;
use App\Services\HortaService;
use App\Controllers\HortaController;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        HortaModel::class => DI\autowire(HortaModel::class),
        HortaRepository::class => DI\autowire(HortaRepository::class),
        HortaService::class => DI\autowire(HortaService::class),
        HortaController::class => DI\autowire(HortaController::class),
    ]);
};

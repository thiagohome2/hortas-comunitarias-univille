<?php

use DI\ContainerBuilder;
use App\Models\RecursoDoPlanoModel;
use App\Repositories\RecursoDoPlanoRepository;
use App\Services\RecursoDoPlanoService;
use App\Controllers\RecursoDoPlanoController;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        RecursoDoPlanoModel::class => DI\autowire(RecursoDoPlanoModel::class),
        RecursoDoPlanoRepository::class => DI\autowire(RecursoDoPlanoRepository::class),
        RecursoDoPlanoService::class => DI\autowire(RecursoDoPlanoService::class),
        RecursoDoPlanoController::class => DI\autowire(RecursoDoPlanoController::class),
    ]);
};

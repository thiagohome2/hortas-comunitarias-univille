<?php

use DI\ContainerBuilder;
use App\Models\EnderecoModel;
use App\Repositories\EnderecoRepository;
use App\Services\EnderecoService;
use App\Controllers\EnderecoController;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        EnderecoModel::class => DI\autowire(EnderecoModel::class),
        EnderecoRepository::class => DI\autowire(EnderecoRepository::class),
        EnderecoService::class => DI\autowire(EnderecoService::class),
        EnderecoController::class => DI\autowire(EnderecoController::class),
    ]);
};

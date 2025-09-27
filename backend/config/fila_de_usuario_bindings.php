<?php

use DI\ContainerBuilder;
use App\Models\FilaDeUsuarioModel;
use App\Repositories\FilaDeUsuarioRepository;
use App\Services\FilaDeUsuarioService;
use App\Controllers\FilaDeUsuarioController;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        FilaDeUsuarioModel::class => DI\autowire(FilaDeUsuarioModel::class),
        FilaDeUsuarioRepository::class => DI\autowire(FilaDeUsuarioRepository::class),
        FilaDeUsuarioService::class => DI\autowire(FilaDeUsuarioService::class),
        FilaDeUsuarioController::class => DI\autowire(FilaDeUsuarioController::class),
    ]);
};

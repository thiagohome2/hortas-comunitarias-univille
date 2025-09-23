<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use App\Models\UsuarioModel;
use App\Repositories\UsuarioRepository;
use App\Services\UsuarioService;
use App\Controllers\UsuarioController;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        // Model
        UsuarioModel::class => DI\autowire(UsuarioModel::class),

        // Repository
        UsuarioRepository::class => DI\autowire(UsuarioRepository::class),

        // Service
        UsuarioService::class => DI\autowire(UsuarioService::class),

        // Controller
        UsuarioController::class => DI\autowire(UsuarioController::class),
    ]);
};

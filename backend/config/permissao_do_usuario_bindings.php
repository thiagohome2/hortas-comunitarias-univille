<?php

use App\Controllers\PermissaoDoUsuarioController;
use DI\ContainerBuilder;
use App\Models\AssociacaoModel;
use App\Services\PermissaoDoUsuarioService;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        PermissaoDoUsuarioController::class => DI\autowire(PermissaoDoUsuarioController::class),
        PermissaoDoUsuarioService::class => DI\autowire(PermissaoDoUsuarioService::class),
    ]);
};

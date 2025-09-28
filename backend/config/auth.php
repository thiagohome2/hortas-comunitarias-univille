<?php

use App\Middlewares\RoutePermissionMiddleware;
use App\Utils\Permissions\RoutePermissionMap;
use App\Middlewares\JwtMiddleware;
use App\Services\PermissaoDoUsuarioService;

return function (\DI\ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([

        // JWT Middleware
        JwtMiddleware::class => \DI\autowire(JwtMiddleware::class),

        // Mapeamento de permissões
        RoutePermissionMap::class => \DI\create(RoutePermissionMap::class),

        // Middleware de permissões
        RoutePermissionMiddleware::class => \DI\autowire(RoutePermissionMiddleware::class)
            ->constructor(
                \DI\get(RoutePermissionMap::class),
                \DI\get(PermissaoDoUsuarioService::class)
            ),
    ]);
};
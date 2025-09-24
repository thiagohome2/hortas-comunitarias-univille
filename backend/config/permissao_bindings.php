<?php
use DI\ContainerBuilder;
use App\Models\PermissaoModel;
use App\Repositories\PermissaoRepository;
use App\Services\PermissaoService;
use App\Controllers\PermissaoController;

return function(ContainerBuilder $container){
    $container->addDefinitions([
        PermissaoModel::class => DI\autowire(PermissaoModel::class),
        PermissaoRepository::class => DI\autowire(PermissaoRepository::class),
        PermissaoService::class => DI\autowire(PermissaoService::class),
        PermissaoController::class => DI\autowire(PermissaoController::class),
    ]);
};

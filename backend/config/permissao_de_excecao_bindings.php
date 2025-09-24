<?php
use DI\ContainerBuilder;
use App\Models\PermissaoDeExcecaoModel;
use App\Repositories\PermissaoDeExcecaoRepository;
use App\Services\PermissaoDeExcecaoService;
use App\Controllers\PermissaoDeExcecaoController;

return function(ContainerBuilder $container){
    $container->addDefinitions([
        PermissaoDeExcecaoModel::class => DI\autowire(PermissaoDeExcecaoModel::class),
        PermissaoDeExcecaoRepository::class => DI\autowire(PermissaoDeExcecaoRepository::class),
        PermissaoDeExcecaoService::class => DI\autowire(PermissaoDeExcecaoService::class),
        PermissaoDeExcecaoController::class => DI\autowire(PermissaoDeExcecaoController::class),
    ]);
};

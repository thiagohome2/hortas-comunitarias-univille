<?php

use DI\ContainerBuilder;
use App\Models\AssociacaoModel;
use App\Repositories\AssociacaoRepository;
use App\Services\AssociacaoService;
use App\Controllers\AssociacaoController;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        AssociacaoModel::class => DI\autowire(AssociacaoModel::class),
        AssociacaoRepository::class => DI\autowire(AssociacaoRepository::class),
        AssociacaoService::class => DI\autowire(AssociacaoService::class),
        AssociacaoController::class => DI\autowire(AssociacaoController::class),
    ]);
};

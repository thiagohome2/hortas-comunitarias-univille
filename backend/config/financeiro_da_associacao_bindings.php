<?php

use DI\ContainerBuilder;
use App\Models\FinanceiroDaAssociacaoModel;
use App\Repositories\FinanceiroDaAssociacaoRepository;
use App\Services\FinanceiroDaAssociacaoService;
use App\Controllers\FinanceiroDaAssociacaoController;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        FinanceiroDaAssociacaoModel::class => DI\autowire(FinanceiroDaAssociacaoModel::class),
        FinanceiroDaAssociacaoRepository::class => DI\autowire(FinanceiroDaAssociacaoRepository::class),
        FinanceiroDaAssociacaoService::class => DI\autowire(FinanceiroDaAssociacaoService::class),
        FinanceiroDaAssociacaoController::class => DI\autowire(FinanceiroDaAssociacaoController::class),
    ]);
};

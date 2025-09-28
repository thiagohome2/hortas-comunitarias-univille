<?php

use DI\ContainerBuilder;
use App\Models\MensalidadeDaAssociacaoModel;
use App\Repositories\MensalidadeDaAssociacaoRepository;
use App\Services\MensalidadeDaAssociacaoService;
use App\Controllers\MensalidadeDaAssociacaoController;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        MensalidadeDaAssociacaoModel::class => DI\autowire(MensalidadeDaAssociacaoModel::class),
        MensalidadeDaAssociacaoRepository::class => DI\autowire(MensalidadeDaAssociacaoRepository::class),
        MensalidadeDaAssociacaoService::class => DI\autowire(MensalidadeDaAssociacaoService::class),
        MensalidadeDaAssociacaoController::class => DI\autowire(MensalidadeDaAssociacaoController::class),
    ]);
};

<?php

use DI\ContainerBuilder;
use App\Models\MensalidadeDaPlataformaModel;
use App\Repositories\MensalidadeDaPlataformaRepository;
use App\Services\MensalidadeDaPlataformaService;
use App\Controllers\MensalidadeDaPlataformaController;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        MensalidadeDaPlataformaModel::class => DI\autowire(MensalidadeDaPlataformaModel::class),
        MensalidadeDaPlataformaRepository::class => DI\autowire(MensalidadeDaPlataformaRepository::class),
        MensalidadeDaPlataformaService::class => DI\autowire(MensalidadeDaPlataformaService::class),
        MensalidadeDaPlataformaController::class => DI\autowire(MensalidadeDaPlataformaController::class),
    ]);
};

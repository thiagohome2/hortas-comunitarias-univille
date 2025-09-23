<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config/dependencies.php';

use Dotenv\Dotenv;
use DI\ContainerBuilder;
use Illuminate\Database\Capsule\Manager as Capsule;

// Carrega .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
foreach ($_SERVER as $key => $value) {
    if (getenv($key) !== false && !isset($_ENV[$key])) {
        $_ENV[$key] = $value;
    }
}

// Inicializa container
$containerBuilder = new ContainerBuilder();
$dependencies = require __DIR__ . '/config/dependencies.php';
$dependencies($containerBuilder);
$container = $containerBuilder->build();

/** @var Capsule $capsule */
$capsule = $container->get(Capsule::class);

// Executa seeds
$seedsDir = __DIR__ . '/src/Utils/Seeds';
echo "Procurando seeds em: $seedsDir\n";
$files = scandir($seedsDir);
sort($files);

foreach ($files as $file) {
    if (in_array($file, ['.', '..'])) continue;

    $seedName = pathinfo($file, PATHINFO_FILENAME);

    require $seedsDir . '/' . $file;

    $seed = new $seedName($capsule);
    $seed->up();
}

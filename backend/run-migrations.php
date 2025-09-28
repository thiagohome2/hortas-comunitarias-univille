<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config/dependencies.php';

use Dotenv\Dotenv;

// --------------- Carregando .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
foreach ($_SERVER as $key => $value) {
    if (getenv($key) !== false && !isset($_ENV[$key])) {
        $_ENV[$key] = $value;
    }
}

use DI\ContainerBuilder;
use Illuminate\Database\Capsule\Manager as Capsule;

// Inicializa o container e pega o Capsule
$containerBuilder = new ContainerBuilder();
$dependencies = require __DIR__ . '/config/dependencies.php';
$dependencies($containerBuilder);
$container = $containerBuilder->build();

/** @var Capsule $capsule */
$capsule = $container->get(Capsule::class);

// Cria tabela de controle de migrations se não existir
if (!$capsule->schema()->hasTable('migrations')) {
    $capsule->schema()->create('migrations', function ($table) {
        $table->string('migration', 255)->primary();
        $table->timestamp('executed_at')->useCurrent();
    });
}

// Lista todas as migrations
$migrationsDir = __DIR__ . '/src/Utils/Migrations';
$files = scandir($migrationsDir);
sort($files);

// Executa apenas as pendentes
foreach ($files as $file) {
    if (in_array($file, ['.', '..'])) continue;

    $migrationName = pathinfo($file, PATHINFO_FILENAME);

    // Verifica se já rodou
    $executed = $capsule::table('migrations')->where('migration', $migrationName)->exists();
    if ($executed) continue;

    require $migrationsDir . '/' . $file;

    $migration = new $migrationName($capsule);
    $migration->up();

    $capsule::table('migrations')->insert([
        'migration' => $migrationName,
        'executed_at' => date('Y-m-d H:i:s'),
    ]);

    echo "Migration {$migrationName} executada.\n";
}

echo "Todas as migrations pendentes foram executadas.\n";

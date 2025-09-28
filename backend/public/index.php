<?php


require __DIR__ . '/../vendor/autoload.php';

use DI\ContainerBuilder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Dotenv\Dotenv;
use Slim\Factory\AppFactory;
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Middlewares\FormatadorDeErrosMiddleware;
use App\Middlewares\ForcarJsonMiddleware;


// --------------- Carregando .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
foreach ($_SERVER as $key => $value) {
    if (getenv($key) !== false && !isset($_ENV[$key])) {
        $_ENV[$key] = $value;
    }
}

// --------------- Criando containder e injetando dependências
$containerBuilder = new ContainerBuilder();
if (false) { // Setar true em prod
    $containerBuilder->enableCompilation(__DIR__ . '/../var/cache');
}
$dependencies = require __DIR__ . '/../config/dependencies.php';
$dependencies($containerBuilder);

$container = $containerBuilder->build();
$container->get(Capsule::class);

// --------------- Criando app Slim
AppFactory::setContainer($container);
$app = AppFactory::create();

// --------------- Carregando rotas da API
$routes = require __DIR__ . '/../src/Routes/IndexRoutes.php';
$routes($app);

// Carregando middlewares
$app->add(FormatadorDeErrosMiddleware::class);
$app->add(ForcarJsonMiddleware::class);

$app->addBodyParsingMiddleware();

// --------------- Rodando app
$app->run();
?>
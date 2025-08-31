<?php

use Doctrine\DBAL\Connection;
use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Argument\Literal\StringArgument;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Sunlazor\BlondFramework\Console\Application;
use Sunlazor\BlondFramework\Console\Command\MigrateCommand;
use Sunlazor\BlondFramework\Console\Kernel as ConsoleKernel;
use Sunlazor\BlondFramework\Controller\BaseController;
use Sunlazor\BlondFramework\Dbal\ConnectionFactory;
use Sunlazor\BlondFramework\Http\Kernel;
use Sunlazor\BlondFramework\Routing\Router;
use Sunlazor\BlondFramework\Routing\RouterInterface;
use Symfony\Component\Dotenv\Dotenv;

//// Application parameters

// Routes
$routes = include BASE_PATH . '/routes/web.php';
// .env
$dotEnv = new DotEnv();
$dotEnv->load(BASE_PATH . '/.env');
// templates
$viewsPath = BASE_PATH . '/views';
// database
$databaseUrl = $_ENV['APP_DATABASE_URL'];
$databaseMigrationsPath = BASE_PATH . '/database/migrations/';
// commands
$commandsPrefix = 'console:';

//// Application service container
$container = new Container();

// env
$container->add('APP_ENV', new StringArgument($_ENV['APP_ENV'] ?? 'local'));

// Auto-wiring
$container->delegate(new ReflectionContainer(true));

// Commands
$container->add(
    'framework-commands-namespace',
    new StringArgument('Sunlazor\\BlondFramework\\Console\\Command\\'),
);

// Services

$container->add(RouterInterface::class, Router::class);
$container
    ->extend(RouterInterface::class)
    ->addMethodCall('registerRoutes', ['routes' => new ArrayArgument($routes)]);

$container->add(Application::class)->addArgument($container);

$container
    ->add(Kernel::class)
    ->addArgument(RouterInterface::class)
    ->addArgument($container);

$container
    ->add(ConsoleKernel::class)
    ->addArgument($container)
    ->addArgument(Application::class)
;

// Twig
$container
    ->addShared('twig-loader', \Twig\Loader\FilesystemLoader::class)
    ->addArgument(new StringArgument($viewsPath));
$container
    ->addShared('twig', \Twig\Environment::class)
    ->addArgument('twig-loader');

$container->inflector(BaseController::class)->invokeMethod('setContainer', [$container]);

$container->add(ConnectionFactory::class)->addArgument(new StringArgument($databaseUrl));
$container->addShared(
    Connection::class,
    function () use ($container): Connection {
        return $container->get(ConnectionFactory::class)->create();
    },
);

$container
    ->add($commandsPrefix . MigrateCommand::$name, MigrateCommand::class)
    ->addArgument(Connection::class)
    ->addArgument(new StringArgument($databaseMigrationsPath));

return $container;

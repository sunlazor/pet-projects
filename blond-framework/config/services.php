<?php

use App\Services\UserService;
use Doctrine\DBAL\Connection;
use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Argument\Literal\StringArgument;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Sunlazor\BlondFramework\Authentication\SessionAuthentication;
use Sunlazor\BlondFramework\Authentication\SessionAuthInterface;
use Sunlazor\BlondFramework\Console\Application;
use Sunlazor\BlondFramework\Console\Command\MigrateCommand;
use Sunlazor\BlondFramework\Console\Kernel as ConsoleKernel;
use Sunlazor\BlondFramework\Controller\AbstractController;
use Sunlazor\BlondFramework\Dbal\ConnectionFactory;
use Sunlazor\BlondFramework\Event\EventDispatcher;
use Sunlazor\BlondFramework\Http\Kernel;
use Sunlazor\BlondFramework\Http\Middleware\ExtractRouteInfo;
use Sunlazor\BlondFramework\Http\Middleware\RequestHandler;
use Sunlazor\BlondFramework\Http\Middleware\RequestHandlerInterface;
use Sunlazor\BlondFramework\Routing\Router;
use Sunlazor\BlondFramework\Routing\RouterInterface;
use Sunlazor\BlondFramework\Session\Session;
use Sunlazor\BlondFramework\Session\SessionInterface;
use Sunlazor\BlondFramework\Template\TwigFactory;
use Symfony\Component\Dotenv\Dotenv;

//// Application parameters

$basePath = dirname(__DIR__);
// Routes
$routes = include $basePath . '/routes/web.php';
// .env
$dotEnv = new DotEnv();
$dotEnv->load($basePath . '/.env');
// templates
$viewsPath = $basePath . '/views';
// database
$databaseUrl = $_ENV['APP_DATABASE_URL'];
$databaseMigrationsPath = $basePath . '/database/migrations/';
// commands
$commandsPrefix = 'console:';

//// Application service container
$container = new Container();
$container->addShared(ContainerInterface::class, $container);
$container->add('base-path', new StringArgument($basePath));

// Auto-wiring
$container->delegate(new ReflectionContainer(true));

// env
$container->add('APP_ENV', new StringArgument($_ENV['APP_ENV'] ?? 'local'));

// Commands
$container->add(
    'framework-commands-namespace',
    new StringArgument('Sunlazor\\BlondFramework\\Console\\Command\\'),
);

// Services

$container->add(RouterInterface::class, Router::class);

$container->add(ExtractRouteInfo::class)->addArgument(new ArrayArgument($routes));

$container->add(Application::class)->addArgument($container);

$container->add(RequestHandlerInterface::class, RequestHandler::class)->addArgument($container);

$container->addShared(EventDispatcherInterface::class, EventDispatcher::class);

$container
    ->add(Kernel::class)
    ->addArgument($container)
    ->addArgument(RequestHandlerInterface::class)
    ->addArgument(EventDispatcherInterface::class);

$container
    ->add(ConsoleKernel::class)
    ->addArgument($container)
    ->addArgument(Application::class)
;

$container->addShared(SessionInterface::class, Session::class);

// Twig
$container
    ->add('twig-factory', TwigFactory::class)
    ->addArguments([new StringArgument($viewsPath), SessionInterface::class]);

$container->addShared('twig', function () use ($container) {
    return $container->get('twig-factory')->create();
});

$container->inflector(AbstractController::class)->invokeMethod('setContainer', [$container]);

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

$container
    ->add(SessionAuthInterface::class, SessionAuthentication::class)
    ->addArgument(UserService::class)
    ->addArgument(SessionInterface::class);

return $container;

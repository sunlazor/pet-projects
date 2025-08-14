<?php

use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Argument\Literal\StringArgument;
use League\Container\Container;
use League\Container\ReflectionContainer;
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

//// Application service container

$container = new Container();

// env
$container->add('APP_ENV', new StringArgument($_ENV['APP_ENV'] ?? 'local'));

// Auto-wiring
$container->delegate(new ReflectionContainer(true));

$container->add(RouterInterface::class, Router::class);
$container->extend(RouterInterface::class)
    ->addMethodCall('registerRoutes', ['routes' => new ArrayArgument($routes)]);

$container->add(Kernel::class)
    ->addArgument(RouterInterface::class)
    ->addArgument($container)
;

return $container;

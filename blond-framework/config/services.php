<?php

use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Container;
use Sunlazor\BlondFramework\Http\Kernel;
use Sunlazor\BlondFramework\Routing\Router;
use Sunlazor\BlondFramework\Routing\RouterInterface;

// Application parameters

$routes = include BASE_PATH . '/routes/web.php';

// Application service container

$container = new Container();

$container->add(RouterInterface::class, Router::class);
$container->extend(RouterInterface::class)
    ->addMethodCall('registerRoutes', ['routes' => new ArrayArgument($routes)]);

$container->add(Kernel::class)->addArgument(RouterInterface::class);

return $container;

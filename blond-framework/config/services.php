<?php

use League\Container\Container;
use Sunlazor\BlondFramework\Http\Kernel;
use Sunlazor\BlondFramework\Routing\Router;
use Sunlazor\BlondFramework\Routing\RouterInterface;

$container = new Container();

$container->add(RouterInterface::class, Router::class);

$container->add(Kernel::class)->addArgument(RouterInterface::class);

return $container;

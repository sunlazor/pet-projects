<?php

namespace Sunlazor\BlondFramework\Routing;

use Psr\Container\ContainerInterface;
use Sunlazor\BlondFramework\Http\Request;

interface RouterInterface
{
    public function dispatch(Request $request, ContainerInterface $container);
}
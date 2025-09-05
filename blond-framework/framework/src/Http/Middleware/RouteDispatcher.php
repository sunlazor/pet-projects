<?php

namespace Sunlazor\BlondFramework\Http\Middleware;

use Psr\Container\ContainerInterface;
use Sunlazor\BlondFramework\Http\Request;
use Sunlazor\BlondFramework\Http\Response;
use Sunlazor\BlondFramework\Routing\RouterInterface;

class RouteDispatcher implements MiddlewareInterface
{
    public function __construct(
        private readonly RouterInterface $router,
        private readonly ContainerInterface $container,
    ) {}

    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        [$routerHandler, $vars] = $this->router->dispatch($request, $this->container);

        $response = call_user_func_array($routerHandler, $vars);

        return $response;
    }
}
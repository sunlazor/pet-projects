<?php

namespace Sunlazor\BlondFramework\Http\Middleware;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Sunlazor\BlondFramework\Http\Request;
use Sunlazor\BlondFramework\Http\Response;
use Sunlazor\BlondFramework\Routing\Exception\MethodNotAllowedException;
use Sunlazor\BlondFramework\Routing\Exception\RouteNotFoundException;

use function FastRoute\simpleDispatcher;

class ExtractRouteInfo implements MiddlewareInterface
{
    public function __construct(private array $routes) {}

    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $rc) {
            foreach ($this->routes as $route) {
                $rc->addRoute(...$route);
            }
        });

        $routeInfo = $dispatcher->dispatch(
            $request->getMethod(),
            $request->getPath(),
        );

        switch ($routeInfo[0]) {
            case Dispatcher::FOUND:
                $request->setRouteHandler($routeInfo[1][0]);
                $request->setRouteArgs($routeInfo[2]);

                $handler->injectMiddleware($routeInfo[1][1]);

                return $handler->handle($request);
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = implode(', ', $routeInfo[1]);
                throw new MethodNotAllowedException("Allowed methods: {$allowedMethods}");
            case Dispatcher::NOT_FOUND:
                throw new RouteNotFoundException("Route ot found");
            default:
                throw new \InvalidArgumentException("Critical path error");
        }
    }
}
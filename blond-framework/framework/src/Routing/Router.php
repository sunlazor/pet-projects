<?php

namespace Sunlazor\BlondFramework\Routing;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Sunlazor\BlondFramework\Http\Request;
use Sunlazor\BlondFramework\Routing\Exception\MethodNotAllowedException;
use Sunlazor\BlondFramework\Routing\Exception\RouteNotFoundException;
use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{
    public function dispatch(Request $request): array
    {
        [$handler, $vars] = $this->extractRouteInfo($request);

        if (is_array($handler)) {
            [$controller, $method] = $handler;

            return [[new $controller, $method], $vars];
        } elseif (is_callable($handler)) {
            return [$handler, $vars];
        } else {
            throw new \InvalidArgumentException("Critical dispatch error");
        }
    }

    public function extractRouteInfo(Request $request): array
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $rc) {
            $routes = include BASE_PATH . '/routes/web.php';

            foreach ($routes as $route) {
                $rc->addRoute(...$route);
            }
        });

        $routeInfo = $dispatcher->dispatch(
            $request->getMethod(),
            $request->getPath(),
        );

        switch ($routeInfo[0]) {
            case Dispatcher::FOUND:
                return [$routeInfo[1], $routeInfo[2]];
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
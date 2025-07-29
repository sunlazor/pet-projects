<?php

namespace Sunlazor\BlondFramework\Routing;

use FastRoute\RouteCollector;
use Sunlazor\BlondFramework\Http\Request;

use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{

    public function dispatch(Request $request): array
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

        [$status, [$controller, $method], $vars] = $routeInfo;

        return [[new $controller, $method], $vars];
    }
}
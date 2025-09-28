<?php

namespace Sunlazor\BlondFramework\Routing;

use Psr\Container\ContainerInterface;
use Sunlazor\BlondFramework\Controller\AbstractController;
use Sunlazor\BlondFramework\Http\Request;

class Router implements RouterInterface
{
    public function dispatch(Request $request, ContainerInterface $container): array
    {
        $handler = $request->getRouteHandler();
        $vars = $request->getRouteArgs();

        if (is_array($handler)) {
            [$controllerId, $method] = $handler;
            $controller = $container->get($controllerId);

            if (is_subclass_of($controller, AbstractController::class)) {
                $controller->setRequest($request);
            }

            return [[$controller, $method], $vars];
        } elseif (is_callable($handler)) {
            return [$handler, $vars];
        } else {
            throw new \InvalidArgumentException("Critical dispatch error");
        }
    }
}
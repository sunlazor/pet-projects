<?php

namespace Sunlazor\BlondFramework\Routing;

class Route
{

    public static function get(string $uri, callable|array $handler, array $middleware = [])
    {
        return ['GET', $uri, [$handler, $middleware]];
    }

    public static function post(string $uri, callable|array $handler, array $middleware = [])
    {
        return ['POST', $uri, [$handler, $middleware]];
    }
}
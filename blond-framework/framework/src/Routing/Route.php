<?php

namespace Sunlazor\BlondFramework\Routing;

class Route
{

    public static function get(string $uri, callable|array $handler)
    {
        return ['GET', $uri, $handler];
    }

    public static function post(string $uri, callable|array $handler)
    {
        return ['POST', $uri, $handler];
    }
}
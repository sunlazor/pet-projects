<?php

namespace Sunlazor\BlondFramework\Routing;

use Sunlazor\BlondFramework\Http\Request;

interface RouterInterface
{
    public function dispatch(Request $request);

    public function registerRoutes(array $routes);
}
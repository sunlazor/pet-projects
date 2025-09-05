<?php

namespace Sunlazor\BlondFramework\Http\Middleware;

use Sunlazor\BlondFramework\Http\Request;
use Sunlazor\BlondFramework\Http\Response;

class Authenticate implements MiddlewareInterface
{
    private bool $isAuthenticated = true;

    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        if (!$this->isAuthenticated) {
            return new Response('Authentication filed', 401);
        }

        return $handler->handle($request);
    }
}
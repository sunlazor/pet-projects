<?php

namespace Sunlazor\BlondFramework\Http;

class Authenticate implements MiddlewareInterface
{
    private bool $isAuthenticated = false;

    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        if (!$this->isAuthenticated) {
            return new Response('Authentication filed', 401);
        }

        return $handler->handle($request);
    }
}
<?php

namespace Sunlazor\BlondFramework\Http;

class Success implements MiddlewareInterface
{
    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        return new Response('Success', 200);
    }
}
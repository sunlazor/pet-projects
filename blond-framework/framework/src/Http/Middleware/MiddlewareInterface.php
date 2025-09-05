<?php

namespace Sunlazor\BlondFramework\Http;

interface MiddlewareInterface
{
    public function process(Request $request, RequestHandlerInterface $handler): Response;
}
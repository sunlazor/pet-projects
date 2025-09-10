<?php

namespace Sunlazor\BlondFramework\Http\Middleware;

use Sunlazor\BlondFramework\Http\Request;
use Sunlazor\BlondFramework\Http\Response;

interface RequestHandlerInterface
{
    public function injectMiddleware(array $middleware): void;

    public function handle(Request $request): Response;
}
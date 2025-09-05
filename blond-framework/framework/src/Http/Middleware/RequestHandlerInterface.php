<?php

namespace Sunlazor\BlondFramework\Http;

interface RequestHandlerInterface
{
    public function handle(Request $request): Response;
}
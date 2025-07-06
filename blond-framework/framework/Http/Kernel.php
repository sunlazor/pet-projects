<?php

namespace Sunlazor\BlondFramework\Http;

class Kernel
{

    public function handle(Request $request): Response
    {
        $content = '<h1>Content!</h1>';

        return new Response($content);
    }
}
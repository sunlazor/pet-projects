<?php

namespace App\Controller;

use Sunlazor\BlondFramework\Http\Response;

class HelloController
{
    public function hello(): Response
    {
        return new Response('Hello World!');
    }
}
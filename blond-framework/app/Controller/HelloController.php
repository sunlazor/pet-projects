<?php

namespace App\Controller;

use App\Services\DependOnMeService;
use Sunlazor\BlondFramework\Http\Response;

class HelloController
{
    public function __construct(private readonly DependOnMeService $dependOnMeService)
    {
    }

    public function hello(): Response
    {
        return new Response('Hello World!' . " " . $this->dependOnMeService->getRandom());
    }
}
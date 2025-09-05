<?php

namespace Sunlazor\BlondFramework\Http\Middleware;

use App\Services\DependOnMeService;
use Sunlazor\BlondFramework\Http\Request;
use Sunlazor\BlondFramework\Http\Response;

class Success implements MiddlewareInterface
{
    public function __construct(private DependOnMeService $dependOnMeService) {}

    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        dd($this->dependOnMeService->getRandom());

        return new Response('Success', 200);
    }
}
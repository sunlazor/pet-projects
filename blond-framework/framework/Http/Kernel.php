<?php

namespace Sunlazor\BlondFramework\Http;

use Sunlazor\BlondFramework\Routing\RouterInterface;

class Kernel
{
    public function __construct(
        readonly private RouterInterface $router,
    ) {}

    public function handle(Request $request): Response
    {
        [$routerHandler, $vars] = $this->router->dispatch($request);

        return call_user_func_array($routerHandler, $vars);
    }
}
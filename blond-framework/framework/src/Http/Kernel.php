<?php

namespace Sunlazor\BlondFramework\Http;

use Psr\Container\ContainerInterface;
use Sunlazor\BlondFramework\Routing\Exception\HttpException;
use Sunlazor\BlondFramework\Routing\RouterInterface;

class Kernel
{
    public function __construct(
        readonly private RouterInterface $router,
        readonly private ContainerInterface $container,
    ) {}

    public function handle(Request $request): Response
    {
        try {
            [$routerHandler, $vars] = $this->router->dispatch($request, $this->container);

            $response = call_user_func_array($routerHandler, $vars);
        } catch (HttpException $e) {
            $response = new Response($e->getMessage(), $e->getStatusCode());
        } catch (\Throwable $e) {
            $response = new Response($e->getMessage(), 500);
        }

        return $response;
    }
}
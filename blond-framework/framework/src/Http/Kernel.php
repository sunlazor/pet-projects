<?php

namespace Sunlazor\BlondFramework\Http;

use Psr\Container\ContainerInterface;
use Sunlazor\BlondFramework\Http\Middleware\RequestHandlerInterface;
use Sunlazor\BlondFramework\Routing\Exception\HttpException;
use Sunlazor\BlondFramework\Routing\RouterInterface;

class Kernel
{
    private string $appEnv = 'local';

    public function __construct(
        readonly private RouterInterface $router,
        readonly private ContainerInterface $container,
        readonly private RequestHandlerInterface $requestHandler,
    ) {
        $this->appEnv = $container->get('APP_ENV');
    }

    public function handle(Request $request): Response
    {
        try {
            $response = $this->requestHandler->handle($request);
        } catch (\Exception $e) {
            $response = $this->createExceptionResponse($e);
        }

        return $response;
    }

    private function createExceptionResponse(\Exception $exception)
    {
        if (in_array($this->appEnv, ['local', 'test'], true)) {
            throw $exception;
        }

        if ($exception instanceof HttpException) {
            return new Response($exception->getMessage(), $exception->getStatusCode());
        }

        return new Response('Some fatal server error', 500);
    }
}
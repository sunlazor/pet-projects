<?php

namespace Sunlazor\BlondFramework\Http;

use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Sunlazor\BlondFramework\Http\Event\ResponseEvent;
use Sunlazor\BlondFramework\Http\Middleware\RequestHandlerInterface;
use Sunlazor\BlondFramework\Routing\Exception\HttpException;

class Kernel
{
    private string $appEnv = 'local';

    public function __construct(
        readonly private ContainerInterface $container,
        readonly private RequestHandlerInterface $requestHandler,
        readonly private EventDispatcherInterface $eventDispatcher,
    ) {
        $this->appEnv = $this->container->get('APP_ENV');
    }

    public function handle(Request $request): Response
    {
        try {
            $response = $this->requestHandler->handle($request);
        } catch (\Exception $e) {
            $response = $this->createExceptionResponse($e);
        }

        $this->eventDispatcher->dispatch(new ResponseEvent($request, $response));

        return $response;
    }

    public function terminate(Request $request, Response $response): void
    {
        $request->getSession()->clearFlash();
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
<?php

namespace Sunlazor\BlondFramework\Http\Middleware;

use Psr\Container\ContainerInterface;
use Sunlazor\BlondFramework\Http\Request;
use Sunlazor\BlondFramework\Http\Response;

class RequestHandler implements RequestHandlerInterface
{
    private array $middlewares = [
        SessionStart::class,
        Authenticate::class,
        RouteDispatcher::class,
    ];

    public function __construct(private ContainerInterface $container) {}

    public function handle(Request $request): Response
    {
        // Если нет middleware-классов для выполнения, вернуть ответ по умолчанию
        // Ответ должен был быть возвращен до того, как список станет пустым
        if (empty($this->middlewares)) {
            return new Response('Internal error', 500);
        }

        // Получить следующий middleware-класс для выполнения
        $middlewareClass = array_shift($this->middlewares);

        // Создать новый экземпляр вызова процесса middleware на нем
        /** @var MiddlewareInterface $middleware */
        $middleware = $this->container->get($middlewareClass);

        return $middleware->process($request, $this);
    }
}
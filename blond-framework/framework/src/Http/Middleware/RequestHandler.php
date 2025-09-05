<?php

namespace Sunlazor\BlondFramework\Http;

class RequestHandler implements RequestHandlerInterface
{
    private array $middlewares = [
        Authenticate::class,
        Success::class,
    ];

    public function handle(Request $request): Response
    {
        // Если нет middleware-классов для выполнения, вернуть ответ по умолчанию
        // Ответ должен был быть возвращен до того, как список станет пустым
        if (empty($this->middlewares)) {
            return new Response('Internal error', 500);
        }

        // Получить следующий middleware-класс для выполнения
        /** @var MiddlewareInterface $middlewareClass */
        $middlewareClass = array_shift($this->middlewares);

        // Создать новый экземпляр вызова процесса middleware на нем
        $response = new $middlewareClass()->process($request, $this);

        return $response;
    }
}
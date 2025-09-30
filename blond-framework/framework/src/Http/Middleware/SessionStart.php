<?php

namespace Sunlazor\BlondFramework\Http\Middleware;

use Sunlazor\BlondFramework\Http\Request;
use Sunlazor\BlondFramework\Http\Response;
use Sunlazor\BlondFramework\Session\SessionInterface;

class SessionStart implements MiddlewareInterface
{
    public function __construct(private SessionInterface $session) {}

    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        $this->session->start();

        $request->setSession($this->session);

        return $handler->handle($request);
    }
}
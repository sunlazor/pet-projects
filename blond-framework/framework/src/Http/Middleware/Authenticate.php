<?php

namespace Sunlazor\BlondFramework\Http\Middleware;

use Sunlazor\BlondFramework\Authentication\SessionAuthInterface;
use Sunlazor\BlondFramework\Http\RedirectResponse;
use Sunlazor\BlondFramework\Http\Request;
use Sunlazor\BlondFramework\Http\Response;
use Sunlazor\BlondFramework\Session\SessionInterface;

class Authenticate implements MiddlewareInterface
{
    public function __construct(
        private SessionAuthInterface $sessionAuth,
        private SessionInterface $session,
    ) {}

    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        $this->session->start();

        if (!$this->sessionAuth->check()) {
            $this->session->setFlash('error', 'Authentication filed');

            return new RedirectResponse('/login');
        }

        return $handler->handle($request);
    }
}
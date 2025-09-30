<?php

namespace App\Services;

use Sunlazor\BlondFramework\Authentication\SessionAuthInterface;
use Sunlazor\BlondFramework\Controller\AbstractController;
use Sunlazor\BlondFramework\Http\RedirectResponse;
use Sunlazor\BlondFramework\Http\Response;

class LoginController extends AbstractController {
    public function __construct(private SessionAuthInterface $sessionAuth) {}

    public function form(): Response
    {
        $content = $this->twigRender('login.html.twig');

        return new Response($content);
    }

    public function login(): Response
    {
        $isAuth = $this->sessionAuth->authenticate(
            $this->request->input('email'),
            $this->request->input('password'),
        );

        if (!$isAuth) {
            $this->request->getSession()->setFlash('error', 'Неверный логин или пароль');

            return new RedirectResponse('/login');
        }

        $this->request->getSession()->setFlash('success', 'Успешный вход');

        return new RedirectResponse('/dash');
    }

    public function logout(): Response
    {
        $this->sessionAuth->logout();

        return new RedirectResponse('/login');
    }
}
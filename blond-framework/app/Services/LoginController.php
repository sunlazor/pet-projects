<?php

namespace App\Services;

use Sunlazor\BlondFramework\Authentication\SessionAuthInterface;
use Sunlazor\BlondFramework\Controller\BaseController;
use Sunlazor\BlondFramework\Http\Response;

class LoginController extends BaseController {
    public function __construct(private SessionAuthInterface $sessionAuth) {}

    public function form(): Response
    {
        $content = $this->twigRender('login.html.twig');

        return new Response($content);
    }

    public function login(): Response
    {
        $res = $this->sessionAuth->authenticate(
            $this->request->input('email'),
            $this->request->input('password'),
        );

        dd($res);
    }
}
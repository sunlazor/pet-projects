<?php

namespace App\Services;

use Sunlazor\BlondFramework\Controller\BaseController;
use Sunlazor\BlondFramework\Http\Response;

class LoginController extends BaseController {
    public function form(): Response
    {
        $content = $this->twigRender('login.html.twig');

        return new Response($content);
    }

    public function login(): Response
    {
        dd($this->request);
    }
}
<?php

namespace App\Controller;

use Sunlazor\BlondFramework\Controller\BaseController;
use Sunlazor\BlondFramework\Http\Response;

class RegistrationController extends BaseController {
    public function form(): Response
    {
        $content = $this->twigRender('registration.html.twig');

        return new Response($content);
    }

    public function registration(): Response
    {
        dd($this->request);
    }
}
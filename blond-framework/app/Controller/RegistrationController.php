<?php

namespace App\Controller;

use App\Form\User\RegistrationForm;
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
        $form = new RegistrationForm();
        $form->setFields(
            $this->request->input('email'),
            $this->request->input('password'),
            $this->request->input('password_confirm'),
            $this->request->input('name'),
        );

        dd($form);
    }
}
<?php

namespace App\Controller;

use App\Form\User\RegistrationForm;
use App\Services\UserService;
use Sunlazor\BlondFramework\Controller\BaseController;
use Sunlazor\BlondFramework\Http\RedirectResponse;
use Sunlazor\BlondFramework\Http\Response;

class RegistrationController extends BaseController
{
    public function __construct(private UserService $userService) {}

    public function form(): Response
    {
        $content = $this->twigRender('registration.html.twig');

        return new Response($content);
    }

    public function registration(): Response
    {
        // 1. Создайте модель формы
        $form = new RegistrationForm($this->userService);
        $form->setFields(
            $this->request->input('email'),
            $this->request->input('password'),
            $this->request->input('password_confirm'),
            $this->request->input('name'),
        );

        // 2. Валидация
        // Если есть ошибки валидации, добавить в сессию и перенаправить на форму
        if ($form->hasValidationErrors()) {
            foreach ($form->getValidationErrors() as $error) {
                $this->request->getSession()->setFlash('error', $error);
            }

            return new RedirectResponse('/reg');
        }

        // 3. Зарегистрировать пользователя, вызвав $form->save()
        $user = $form->save();

        // 4. Добавить сообщение об успешной регистрации
        $this->request->getSession()->setFlash(
            'success', "Пользователь {$user->getEmail()} зарегистрирован!"
        );
        // 5. Войти в систему под пользователем

        // 6. Перенаправить на нужную страницу
        return new RedirectResponse('/reg');
    }
}
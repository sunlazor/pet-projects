<?php

namespace App\Form\User;

use App\Entity\User;
use App\Services\UserService;

class RegistrationForm
{
    private string $name;
    private string $email;
    private string $password;
    private string $passwordConfirm;

    public function __construct(private UserService $userService) {}

    public function setFields(
        string $email,
        string $password,
        string $passwordConfirm,
        string|null $name = null,
    ): void {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->passwordConfirm = $passwordConfirm;
    }

    public function hasValidationErrors(): bool
    {
        return !empty($this->getValidationErrors());
    }

    public function getValidationErrors(): array
    {
        $errors = [];

        if (!empty($this->name) && strlen($this->name) > 25) {
            $errors[] = 'Смените имя на покороче, по-братски прошу';
        }

        if (empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Ну это не эмейл, а хрень какая-то. Давай по новой';
        }

        if (empty($this->password) || strlen($this->password) < 8) {
            $errors[] = 'Какой-то пароль не секюрный. Напряги извилины и настучи новый';
        }

        if ($this->password !== $this->passwordConfirm) {
            $errors[] = 'Подожжи! А что ты мне два разных пароля подсунул? Не стараешься совсем, сделай как нужно';
        }

        return $errors;
    }

    public function save(): User
    {
        $user = User::create(
            $this->email,
            $this->password,
            new \DateTimeImmutable(),
            $this->name,
        );

        $userId = $this->userService->save($user);

        return $this->userService->findById($userId);
    }
}
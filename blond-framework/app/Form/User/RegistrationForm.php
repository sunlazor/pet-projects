<?php

namespace App\Form\User;

class RegistrationForm
{
    private string $name;
    private string $email;
    private string $password;
    private string $passwordConfirm;

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
}
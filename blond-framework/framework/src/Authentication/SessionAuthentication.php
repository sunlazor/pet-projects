<?php

namespace Sunlazor\BlondFramework\Authentication;

class SessionAuthentication implements SessionAuthInterface
{
    public function __construct(private UserServiceInterface $userService) {}

    public function authenticate(string $email, string $password): bool
    {
        $user = $this->userService->findByEmail($email);

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user->getPassword())) {
            return false;
        }

        $this->login($user);

        return true;
    }

    public function login(AuthUserInterface $user)
    {
        // TODO: Implement login() method.
    }

    public function logout()
    {
        // TODO: Implement logout() method.
    }

    public function getUser(): AuthUserInterface
    {
        // TODO: Implement getUser() method.
    }
}
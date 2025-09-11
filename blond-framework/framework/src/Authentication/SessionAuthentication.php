<?php

namespace Sunlazor\BlondFramework\Authentication;

use Sunlazor\BlondFramework\Session\Session;
use Sunlazor\BlondFramework\Session\SessionInterface;

class SessionAuthentication implements SessionAuthInterface
{
    private AuthUserInterface $user;

    public function __construct(private UserServiceInterface $userService, private SessionInterface $session) {}

    public function check(): bool
    {
        return $this->session->has(Session::AUTH_KEY);
    }

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
        $this->session->set(Session::AUTH_KEY, $user->getId());

        $this->user = $user;
    }

    public function logout()
    {
        // TODO: Implement logout() method.
    }

    public function getUser(): AuthUserInterface
    {
        return $this->user;
    }
}
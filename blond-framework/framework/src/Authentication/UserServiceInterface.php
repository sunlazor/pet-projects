<?php

namespace Sunlazor\BlondFramework\Authentication;

interface UserServiceInterface {
    public function findByEmail(string $email): AuthUserInterface|null;
}
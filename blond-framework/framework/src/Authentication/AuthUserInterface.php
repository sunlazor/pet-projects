<?php

namespace Sunlazor\BlondFramework\Authentication;

interface AuthUserInterface {
    public function getId(): int|null;

    public function getEmail(): string;

    public function getPassword(): string;
}
<?php

namespace App\Entity;

class User
{
    public function __construct(
        private int|null $id,
        private string $email,
        private string $password,
        private string|null $name,
        private \DateTimeImmutable|null $createdAt,
    ) {}

    public function create(
        string $email,
        string $password,
        \DateTimeImmutable $createdAt = new \DateTimeImmutable(),
        int|null $id = null,
        string|null $name = null,
    ): static {
        return new static($id, $email, $password, $name, $createdAt);
    }
}
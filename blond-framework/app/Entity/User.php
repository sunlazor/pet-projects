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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public static function create(
        string $email,
        string $password,
        \DateTimeImmutable|null $createdAt = null,
        string|null $name = null,
        int|null $id = null,
    ): static {
        return new static($id, $email, $password, $name, $createdAt ?? new \DateTimeImmutable());
    }
}
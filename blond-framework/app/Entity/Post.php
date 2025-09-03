<?php

namespace App\Entity;

class Post
{
    public function __construct(
        private int|null $id,
        private string $title,
        private string $content,
        private \DateTimeImmutable|null $createdAt,
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public static function create(
        string $title,
        string $content,
        int|null $id = null,
        \DateTimeImmutable|null $createdAt = null,
    ): static {
        return new static($id, $title, $content, $createdAt ?? new \DateTimeImmutable());
    }
}
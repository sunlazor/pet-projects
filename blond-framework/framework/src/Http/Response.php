<?php

namespace Sunlazor\BlondFramework\Http;

class Response
{
    public function __construct(
        private mixed $content,
        private int $statusCode = 200,
        private array $headers = [],
    ) {
        http_response_code($this->statusCode);
    }

    public function send()
    {
        ob_start();

        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }

        echo $this->content;

        ob_end_flush();
    }

    public function getHeader(string $key): mixed
    {
        return $this->headers[$key] ?? null;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeader(string $key, mixed $value): void
    {
        $this->headers[$key] = $value;
    }

    public function getContent(): mixed
    {
        return $this->content;
    }
}
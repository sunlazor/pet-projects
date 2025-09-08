<?php

namespace Sunlazor\BlondFramework\Http;

use Sunlazor\BlondFramework\Session\SessionInterface;

class Request
{
    private SessionInterface $session;

    public function __construct(
        private readonly array $getParams,
        private readonly array $postData,
        private readonly array $cookies,
        private readonly array $filse,
        private readonly array $server,
    ) {}

    public static function createFromGlobals(): static
    {
        return new static($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
    }

    public function getPath(): false|string
    {
        return strtok($this->server['REQUEST_URI'], '?');
    }

    public function getMethod(): false|string
    {
        return $this->server['REQUEST_METHOD'];
    }

    public function getPostData(): array
    {
        return $this->postData;
    }

    public function getSession(): SessionInterface
    {
        return $this->session;
    }

    public function setSession(SessionInterface $session): void
    {
        $this->session = $session;
    }
}
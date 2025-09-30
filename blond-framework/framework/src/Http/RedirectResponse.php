<?php

namespace Sunlazor\BlondFramework\Http;

class RedirectResponse extends Response {
    public function __construct(string $url)
    {
        parent::__construct('', 302, ['Location' => $url]);
    }

    public function send(): void
    {
        header("Location: {$this->getHeader('Location')}", true, 302);
        exit;
    }
}
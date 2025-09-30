<?php

namespace App\Listeners;

use Sunlazor\BlondFramework\Http\Event\ResponseEvent;

class ContentLengthListener {
    private const string CONTENT_LENGTH_STR = 'Content-Length';
    public function __invoke(ResponseEvent $event): void
    {
        $response = $event->getResponse();

        if (!array_key_exists(static::CONTENT_LENGTH_STR, $response->getHeaders())) {
            $response->setHeader(static::CONTENT_LENGTH_STR, strlen($response->getContent()));
        }
    }
}
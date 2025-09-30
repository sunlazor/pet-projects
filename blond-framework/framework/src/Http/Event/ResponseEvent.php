<?php

namespace Sunlazor\BlondFramework\Http\Event;

use Sunlazor\BlondFramework\Event\AbstractEvent;
use Sunlazor\BlondFramework\Http\Request;
use Sunlazor\BlondFramework\Http\Response;

class ResponseEvent extends AbstractEvent
{
    public function __construct(private Request $request, private Response $response) {}

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }
}
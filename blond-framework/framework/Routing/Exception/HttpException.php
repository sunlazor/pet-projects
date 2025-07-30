<?php

namespace Sunlazor\BlondFramework\Routing\Exception;

abstract class HttpException extends \RuntimeException {
    protected int $statusCode = 500;

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
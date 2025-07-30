<?php

namespace Sunlazor\BlondFramework\Routing\Exception;

class MethodNotAllowedException extends HttpException {
    protected int $statusCode = 405;
}
<?php

namespace Sunlazor\BlondFramework\Routing\Exception;

class RouteNotFoundException extends HttpException {
    protected int $statusCode = 404;
}
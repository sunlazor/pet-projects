<?php

namespace App;

define('BASE_PATH', dirname(__DIR__));

include_once BASE_PATH . '/vendor/autoload.php';

use Sunlazor\BlondFramework\Http\Kernel;
use Sunlazor\BlondFramework\Http\Request;
use Sunlazor\BlondFramework\Routing\Router;

$router = new Router();
$kernel = new Kernel($router);

$request = Request::createFromGlobals();
$response = $kernel->handle($request);

$response->send();
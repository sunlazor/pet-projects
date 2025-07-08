<?php

namespace App;

define('BASE_PATH', dirname(__DIR__));

include_once BASE_PATH . '/vendor/autoload.php';

use Sunlazor\BlondFramework\Http\Kernel;
use Sunlazor\BlondFramework\Http\Request;

$request = Request::createFromGlobals();

$kernel = new Kernel($request);

$response = $kernel->handle($request);

$response->send();
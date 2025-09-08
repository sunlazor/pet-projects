<?php

namespace App;

define('BASE_PATH', dirname(__DIR__));

include_once BASE_PATH . '/vendor/autoload.php';

use League\Container\Container;
use Sunlazor\BlondFramework\Http\Kernel;
use Sunlazor\BlondFramework\Http\Request;

/** @var Container $container */
$container = require_once BASE_PATH . '/config/services.php';

/** @var Kernel $kernel */
$kernel = $container->get(Kernel::class);

$request = Request::createFromGlobals();
$response = $kernel->handle($request);

$response->send();

$kernel->terminate($request, $response);
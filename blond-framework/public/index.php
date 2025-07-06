<?php

namespace App;

include_once dirname(__DIR__) . '/vendor/autoload.php';

use Sunlazor\BlondFramework\Http\Kernel;
use Sunlazor\BlondFramework\Http\Request;

$request = Request::createFromGlobals();

$kernel = new Kernel($request);

$response = $kernel->handle($request);

$response->send();
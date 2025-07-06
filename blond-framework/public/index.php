<?php

namespace App;

include_once dirname(__DIR__) . '/vendor/autoload.php';

use Sunlazor\BlondFramework\Http\Request;

$request = Request::createFromGlobals();

dd($request);
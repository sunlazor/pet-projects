<?php

use App\Controller\HelloController;
use Sunlazor\BlondFramework\Routing\Route;

return [
    Route::get('/', [HelloController::class, 'hello']),
];

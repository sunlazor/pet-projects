<?php

use App\Controller\HelloController;
use App\Controller\PostController;
use App\Controller\RegistrationController;
use App\Services\DashboardController;
use App\Services\LoginController;
use Sunlazor\BlondFramework\Http\Response;
use Sunlazor\BlondFramework\Routing\Route;

return [
    Route::get('/', [HelloController::class, 'hello']),
    Route::get('/hi/{name}', function (string $name) {
        return new Response("Hello {$name}!");
    }),
    Route::get('/posts/{id:\d+}', [PostController::class, 'show']),
    Route::get('/posts/create', [PostController::class, 'create']),
    Route::post('/posts', [PostController::class, 'store']),

    Route::get('/reg', [RegistrationController::class, 'form']),
    Route::post('/reg', [RegistrationController::class, 'registration']),

    Route::get('/login', [LoginController::class, 'form']),
    Route::post('/login', [LoginController::class, 'login']),

    Route::get('/dash', [DashboardController::class, 'index']),
];

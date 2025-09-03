<?php

use App\Controller\HelloController;
use App\Controller\PostController;
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
];

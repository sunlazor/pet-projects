<?php

namespace App\Controller;

use Sunlazor\BlondFramework\Http\Response;

class PostController {
    public function get(int $id): Response
    {
        return new Response("PostController get: {$id}");
    }
}
<?php

namespace App\Controller;

use Sunlazor\BlondFramework\Controller\BaseController;
use Sunlazor\BlondFramework\Http\Response;

class PostController extends BaseController
{
    public function get(int $id): Response
    {
        $content = $this->twigRender('post.html.twig', ['postId' => $id]);

        return new Response($content);
    }

    public function create(): Response
    {
        $content = $this->twigRender('post_create.html.twig');

        return new Response($content);
    }
}
<?php

namespace App\Controller;

use App\Entity\Post;
use App\Services\PostService;
use Sunlazor\BlondFramework\Controller\BaseController;
use Sunlazor\BlondFramework\Http\RedirectResponse;
use Sunlazor\BlondFramework\Http\Response;

class PostController extends BaseController
{
    public function __construct(
        private PostService $postService,
    ) {}

    public function create(): Response
    {
        $content = $this->twigRender('post_create.html.twig');

        return new Response($content);
    }

    public function show(int $id): Response
    {
        $post = $this->postService->findById($id);

        $content = $this->twigRender('post.html.twig', ['post' => $post]);

        return new Response($content);
    }

    public function store(): Response
    {
        $post = Post::create($this->request->input('title'), $this->request->input('body'));
        $postId = $this->postService->save($post);

        $this->request->getSession()->setFlash('success', 'Пост создан! Yay!');

        return new RedirectResponse("/posts/{$postId}");
    }
}
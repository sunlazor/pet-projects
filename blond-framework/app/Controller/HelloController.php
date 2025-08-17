<?php

namespace App\Controller;

use App\Services\DependOnMeService;
use Sunlazor\BlondFramework\Controller\BaseController;
use Sunlazor\BlondFramework\Http\Response;

class HelloController extends BaseController
{
    public function __construct(
        private readonly DependOnMeService $dependOnMeService,
    ) {}

    public function hello(): Response
    {
        $content = $this->twigRender(
            'home.html.twig',
            ['random' => $this->dependOnMeService->getRandom()],
        );

        return new Response($content);
    }
}
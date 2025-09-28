<?php

namespace App\Services;

use Sunlazor\BlondFramework\Controller\AbstractController;
use Sunlazor\BlondFramework\Http\Response;

class DashboardController extends AbstractController {
    public function index(): Response
    {
        $content = $this->twigRender('dashboard.html.twig');

        return new Response($content);
    }
}
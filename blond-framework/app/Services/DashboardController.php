<?php

namespace App\Services;

use Sunlazor\BlondFramework\Controller\BaseController;
use Sunlazor\BlondFramework\Http\Response;

class DashboardController extends BaseController {
    public function index(): Response
    {
        $content = $this->twigRender('dashboard.html.twig');

        return new Response($content);
    }
}
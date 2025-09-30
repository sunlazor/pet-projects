<?php

namespace Sunlazor\BlondFramework\Controller;

use Psr\Container\ContainerInterface;
use Sunlazor\BlondFramework\Http\Request;

abstract class AbstractController
{
    protected ContainerInterface|null $container = null;
    protected Request $request;

    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    public function twigRender(string $content, array $params = []): string
    {
        return $this->container->get('twig')->render($content, $params);
    }
}
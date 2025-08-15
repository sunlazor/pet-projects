<?php

namespace Sunlazor\BlondFramework\Controller;

use Psr\Container\ContainerInterface;

abstract class BaseController
{
    protected ContainerInterface|null $container = null;

    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }
}
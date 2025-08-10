<?php

namespace Sunlazor\BlondFramework\Container;

use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private array $services = [];

    public function add(string $id, string|object|null $concrete = null): void
    {
        $this->services[$id] = $concrete;
    }

    /**
     * @inheritDoc
     */
    public function get(string $id)
    {
        return new $this->services[$id];
    }

    /**
     * @inheritDoc
     */
    public function has(string $id): bool
    {
        // TODO: Implement has() method.
    }
}
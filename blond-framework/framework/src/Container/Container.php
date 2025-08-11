<?php

namespace Sunlazor\BlondFramework\Container;

use Psr\Container\ContainerInterface;
use Sunlazor\BlondFramework\Container\Exceptions\ContainerException;

class Container implements ContainerInterface
{
    private array $services = [];

    public function add(string $id, string|object|null $concrete = null): void
    {
        if (is_null($concrete)) {
            if (!class_exists($id)) {
                throw new ContainerException("This is not a valid class name: {$id}");
            }

            $concrete = $id;
        }

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
        return array_key_exists($id, $this->services);
    }
}
<?php

namespace Sunlazor\BlondFramework\Container;

use Psr\Container\ContainerInterface;
use ReflectionClass;
use Sunlazor\BlondFramework\Container\Exceptions\ContainerException;
use Sunlazor\BlondFramework\Container\Exceptions\NotFoundInContainerException;

class Container implements ContainerInterface
{
    private array $services = [];

    public function add(string $id, string|object|null $concrete = null): void
    {
        if (is_null($concrete)) {
            if (!class_exists($id)) {
                throw new ContainerException("This is not a valid class name: {$id}");
            }

            $instance = $this->resolve($id);
        } else {
            $instance = $this->resolve($concrete);
        }

        $this->services[$id] = $instance;
    }

    /**
     * @inheritDoc
     */
    public function get(string $id)
    {
        if ($this->has($id)) {
            return $this->services[$id];
        } else {
            throw new NotFoundInContainerException("Service is not inside of the container: {$id}");
        }
    }

    /**
     * @inheritDoc
     */
    public function has(string $id): bool
    {
        return array_key_exists($id, $this->services);
    }

    private function resolve(string|object $objectOrClass): object|string|null
    {
        $dependencyClass = new ReflectionClass($objectOrClass);

        $constructor = $dependencyClass->getConstructor();

        if(null === $constructor) {
            return $dependencyClass->newInstance();
        }

        $constructorParams = $constructor->getParameters();

        $resolvedDependencies = $this->resolveDependencies($constructorParams);

        return $dependencyClass->newInstanceArgs($resolvedDependencies);
    }

    private function resolveDependencies(array $constructorParams): array
    {
        $classDependencies = [];
        /** @var \ReflectionParameter $param */
        foreach ($constructorParams as $param) {
            $paramType = $param->getType();

            $this->add($paramType->getName());
            $service = $this->get($paramType->getName());

            $classDependencies[] = $service;
        }

        return $classDependencies;
    }
}
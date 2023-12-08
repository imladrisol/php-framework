<?php

declare(strict_types=1);

namespace Framework\Container;

use Framework\Container\Exceptions\ContainerException;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private array $services = [];

    /**
     * @inheritDoc
     */
    public function get(string $id)
    {
        if (!$this->has($id)) {
            if (!class_exists($id)) {
                throw new ContainerException("Service $id can't be resolved");
            }

            $this->add($id);
        }

        $instance = $this->resolve($this->services[$id]);

        return $instance;
    }

    /**
     * @inheritDoc
     */
    public function has(string $id): bool
    {
        return array_key_exists($id, $this->services);
    }

    public function add(string $id, string|object $concrete = null)
    {
        if (is_null($concrete)) {
            if (!class_exists($id)) {
                throw new ContainerException("Service $id not found");
            }

            $concrete = $id;
        }
        $this->services[$id] = $concrete;
    }

    private function resolve($class)
    {
        $reflectionClass = new \ReflectionClass($class);
        $constructor = $reflectionClass->getConstructor();
        if (is_null($constructor)) {
            return $reflectionClass->newInstance();
        }
        $constructorParams = $constructor->getParameters();
        $classDependencies = $this->resolveClassDependencies($constructorParams);
        $instance = $reflectionClass->newInstanceArgs($classDependencies);

        return $instance;
    }

    private function resolveClassDependencies(array $constructorParams) {
        $classDependencies = [];

        /** @var \ReflectionParameter $constructorParam */
        foreach ($constructorParams as $constructorParam) {
            $serviceType = $constructorParam->getType();
            $service = $this->get($serviceType->getName());
            $classDependencies[] = $service;
        }

        return $classDependencies;
    }
}

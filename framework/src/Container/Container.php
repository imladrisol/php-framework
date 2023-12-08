<?php

declare(strict_types=1);

namespace Framework\Container;

use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private array $services = [];

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

    public function add(string $id, string|object $concrete = null)
    {
        $this->services[$id] = $concrete;
    }
}

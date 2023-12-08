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
        if (is_null($concrete)) {
            if (!class_exists($id)) {
                throw new ContainerException("Service $id not found");
            }

            $concrete = $id;
        }
        $this->services[$id] = $concrete;
    }
}

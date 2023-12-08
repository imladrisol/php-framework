<?php

declare(strict_types=1);

namespace Framework\Tests;

class SomecodeClass
{
    public function __construct(
        private readonly DependencyTestClass $dependencyClass
    )
    {

    }

    public function getDependencyClass(): DependencyTestClass
    {
        return $this->dependencyClass;
    }
}

<?php

declare(strict_types=1);

namespace Framework\Tests;

use Framework\Container\Container;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function testGettingServiceFromContainer()
    {
        $container = new Container();
        $container->add('somecode-class', SomecodeClass::class);
        $this->assertInstanceOf(SomecodeClass::class, $container->get('somecode-class'));
    }
}

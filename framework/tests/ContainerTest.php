<?php

declare(strict_types=1);

namespace Framework\Tests;

use Framework\Container\Container;
use Framework\Container\Exceptions\ContainerException;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function testGettingServiceFromContainer()
    {
        $container = new Container();
        $container->add('somecode-class', SomecodeClass::class);
        $this->assertInstanceOf(SomecodeClass::class, $container->get('somecode-class'));
    }

    public function testContainerThrowExceptionWhenAddWrongService()
    {
        $container = new Container();
        $this->expectException(ContainerException::class);
        $container->add('no-class');
    }

    public function testHasService()
    {
        $container = new Container();
        $container->add('somecode-class', SomecodeClass::class);
        $this->assertTrue($container->has('somecode-class'));
        $this->assertFalse($container->has('somecode-class1'));
    }

    public function testRecursivelyAutowired()
    {
        $container = new Container();
        $container->add('somecode-class', SomecodeClass::class);
        /** @var SomecodeClass $somecodeClass */
        $somecodeClass = $container->get('somecode-class');
        $dependencyTest = $somecodeClass->getDependencyClass();
        $this->assertInstanceOf(DependencyTestClass::class, $somecodeClass->getDependencyClass());
        $this->assertInstanceOf(Youtube::class, $dependencyTest->getYoutube());
        $this->assertInstanceOf(Telegram::class, $dependencyTest->getTelega());
    }
}

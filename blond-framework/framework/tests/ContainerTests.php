<?php

namespace Sunlazor\BlondFramework\Tests;

use PHPUnit\Framework\TestCase;
use Sunlazor\BlondFramework\Container\Container;
use Sunlazor\BlondFramework\Container\Exceptions\ContainerException;

class ContainerTests extends TestCase
{
    public function test_getting_service_from_container()
    {
        $container = new Container();

        $container->add('test-class', FooClass::class);

        $this->assertInstanceOf(FooClass::class, $container->get('test-class'));
    }

    public function test_Container_returns_exception_on_wrong_class()
    {
        $container = new Container();

        $this->expectException(ContainerException::class);

        $container->add('wrong-class');
    }

    public function test_Container_implements_has_method()
    {
        $container = new Container();

        $container->add('test-class', FooClass::class);

        $this->assertTrue($container->has('test-class'));
        $this->assertFalse($container->has('wrong-class'));
    }

    public function test_recursive_autowiring()
    {
        $container = new Container();

        $container->add('test-class', FooClass::class);

        /** @var FooClass $wiredClass */
        $wiredClass = $container->get('test-class');

        $this->assertInstanceOf(DependOnMe::class, $wiredClass->getDependOnMe());
        $this->assertInstanceOf(DeeperDependOne::class, $wiredClass->getDependOnMe()->getDependOne());
        $this->assertInstanceOf(DeeperDependTwo::class, $wiredClass->getDependOnMe()->getDependTwo());
    }
}
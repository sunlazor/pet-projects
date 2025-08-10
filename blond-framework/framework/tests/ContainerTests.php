<?php

namespace Sunlazor\BlondFramework\Tests;

use PHPUnit\Framework\TestCase;
use Sunlazor\BlondFramework\Container\Container;

class ContainerTests extends TestCase
{
    public function test_assert_true()
    {
        $this->assertTrue(false);
    }

    public function test_getting_service_from_container()
    {
        $container = new Container();

        $container->add('test-class', FooClass::class);

        $this->assertInstanceOf(FooClass::class, $container->get('test-class'));
    }
}
<?php

namespace Sunlazor\BlondFramework\Tests;

use Sunlazor\BlondFramework\Session\Session;

class SessionTest extends \PHPUnit\Framework\TestCase {
    protected function setUp(): void
    {
        unset($_SESSION);
    }

    public function test_get_set_flash(): void
    {
        $sus = new Session();
        $sus->setFlash('success', 'Урааа!!');
        $sus->setFlash('error', 'Ну чёт намудрил...');

        $this->assertTrue($sus->hasFlash('success'));
        $this->assertTrue($sus->hasFlash('error'));

        $this->assertEquals(['Урааа!!'], $sus->getFlash('success'));
        $this->assertEquals(['Ну чёт намудрил...'], $sus->getFlash('error'));
        $this->assertEquals([], $sus->getFlash('warning'));
    }
}
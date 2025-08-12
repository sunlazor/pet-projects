<?php

namespace Sunlazor\BlondFramework\Tests;

class FooClass
{
    public function __construct(private readonly DependOnMe $dependOnMe)
    {
    }

    public function getDependOnMe(): DependOnMe
    {
        return $this->dependOnMe;
    }
}
<?php

namespace Sunlazor\BlondFramework\Tests;

class DependOnMe
{
    public function __construct(private readonly DeeperDependOne $dependOne, private readonly DeeperDependTwo $dependTwo)
    {
    }

    public function getDependOne(): DeeperDependOne
    {
        return $this->dependOne;
    }

    public function getDependTwo(): DeeperDependTwo
    {
        return $this->dependTwo;
    }

}
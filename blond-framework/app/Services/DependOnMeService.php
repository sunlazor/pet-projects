<?php

namespace App\Services;

class DependOnMeService
{
    public function getRandom(): int
    {
        return \random_int(0, 100);
    }
}
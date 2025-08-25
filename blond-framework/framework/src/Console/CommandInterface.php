<?php

namespace Sunlazor\BlondFramework\Console;

interface CommandInterface
{
    public function execute(array $parameters = []): int;
}
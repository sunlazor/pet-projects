<?php

namespace Sunlazor\BlondFramework\Console\Command;

interface CommandInterface
{
    public function execute(array $parameters = []): int;
}
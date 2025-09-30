<?php

namespace Sunlazor\BlondFramework\Console;

use Psr\Container\ContainerInterface;
use Sunlazor\BlondFramework\Console\Command\CommandInterface;

class Application
{
    public function __construct(private readonly ContainerInterface $container) {}

    public function run(): int
    {
        $argv = $_SERVER['argv'];

        $commandName = $argv[1] ?? null;
        if (empty($commandName)) {
            throw new \InvalidArgumentException("Command name is required");
        }

        /** @var CommandInterface $command */
        $command = $this->container->get("console:{$commandName}");

        $parsedOptions = $this->parseOptions(array_slice($argv, 2));

        $status = $command->execute($parsedOptions);

        return $status;
    }

    private function parseOptions(array $commandOptions): array {
        $parsedOptions = [];

        foreach ($commandOptions as $option) {
            if(!str_starts_with($option, '--')) {
                continue;
            }

            $parsedOption = explode('=', substr($option, 2));

            $parsedOptions[$parsedOption[0]] = $parsedOption[1] ?? true;
        }

        return $parsedOptions;
    }
}
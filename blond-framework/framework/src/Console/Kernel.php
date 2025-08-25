<?php

namespace Sunlazor\BlondFramework\Console;

use League\Container\DefinitionContainerInterface;
use Sunlazor\BlondFramework\Console\Command\CommandInterface;

class Kernel
{
    public function __construct(private DefinitionContainerInterface $container) {}

    public function handle(): int
    {
        $this->registerCommands();
        return 0;
    }

    private function registerCommands(): void
    {
        $commandFiles = new \DirectoryIterator(__DIR__ . '/Command');
        $commandsNamespace = $this->container->get('framework-commands-namespace');

        foreach ($commandFiles as $commandFile) {
            if (!$commandFile->isFile()) {
                continue;
            }

            $command = $commandsNamespace . pathinfo($commandFile, PATHINFO_FILENAME);

            if (!is_subclass_of($command, CommandInterface::class)) {
                continue;
            }

            $commandName = new \ReflectionClass($command)->getProperty('name')->getDefaultValue();

            $this->container->add('console:' . $commandName, $command);
        }
    }
}
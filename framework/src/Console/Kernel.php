<?php

declare(strict_types=1);

namespace Framework\Console;

use Psr\Container\ContainerInterface;

final class Kernel
{

    public function __construct(
        private readonly ContainerInterface $container
    ) {}

    public function handle(): int
    {
        $this->registerCommands();
        return 0;
    }

    private function registerCommands(): void
    {
        $commandFiles = new \DirectoryIterator(__DIR__ . '/Commands');
        $namespace = $this->container->get('framework-commands-namespace');

        /** @var \DirectoryIterator $commandFile */
        foreach ($commandFiles as $commandFile) {
            if (!$commandFile->isFile()) {
                continue;
            }

            $command = $namespace . pathinfo($commandFile->getFilename(), PATHINFO_FILENAME);

            if (is_subclass_of($command, CommandInterface::class)) {
                $name = (new \ReflectionClass($command))->getProperty('name')->getDefaultValue();

                $this->container->add('console:' . $name, $command);
            }
        }
    }
}

<?php

declare(strict_types=1);

namespace Framework\Console;

use League\Container\Container;

final class Application
{
    public function __construct(
        private readonly Container $container
    ) {}

    public function run(): int
    {
        $argv = $_SERVER['argv'];
        $commandName = $argv[1] ?? '';
        $commandParams = array_slice($argv, 2);
        $commandParams = $this->parseParameters($commandParams);

        if (empty($commandName)) {
            throw new ConsoleException('invalid console command');
        }

        /** @var CommandInterface $command */
        $command = $this->container->get('console:' . $commandName);

        return $command->execute($commandParams);
    }

    private function parseParameters(array $args): array
    {
        $parameters = [];

        foreach ($args as $arg) {
            if (str_starts_with($arg, '--')) {
               list($key, $value) = explode('=', substr($arg, 2));
               $parameters[$key] = $value ?? true;
            }
        }

        return $parameters;
    }
}
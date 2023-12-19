<?php

declare(strict_types=1);

namespace Framework\Console\Commands;

use Framework\Console\CommandInterface;

final class MigrateCommand implements CommandInterface
{

    private string $name = 'migrate';

    public function execute(array $params = []): int
    {

    }
}
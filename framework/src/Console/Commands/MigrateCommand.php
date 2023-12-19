<?php

declare(strict_types=1);

namespace Framework\Console\Commands;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Framework\Console\CommandInterface;

final class MigrateCommand implements CommandInterface
{

    private string $name = 'migrate';
    private const MIGRATIONS_TABLE = 'migrations';

    public function __construct(
        private readonly Connection $connection
    ) {}

    public function execute(array $params = []): int
    {
        $this->createMigrationsTable();
        return 0;
    }

    private function createMigrationsTable()
    {
        $schemaManager = $this->connection->createSchemaManager();
        if (!$schemaManager->tablesExist(self::MIGRATIONS_TABLE)) {
            $schema = new Schema();
            $table = $schema->createTable(self::MIGRATIONS_TABLE);
            $table->addColumn('id', Types::INTEGER, ['unsigned' => true, 'autoincrement' => true]);
            $table->addColumn('migration', Types::STRING);
            $table->addColumn('created_at', Types::DATETIME_IMMUTABLE, ['default' => 'CURRENT_TIMESTAMP']);
            $table->setPrimaryKey(['id']);

            $sqlArray = $schema->toSql($this->connection->getDatabasePlatform());

            $this->connection->executeQuery($sqlArray[0]);

            echo 'migrations table has been created' . PHP_EOL;
        }
    }
}
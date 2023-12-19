<?php

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;

return new class {
    public function up(Schema $schema): void
    {
        //
    }

    public function down(Schema $schema): void
    {
        //echo __CLASS__ . ' method ' . __METHOD__ . PHP_EOL;
    }
};

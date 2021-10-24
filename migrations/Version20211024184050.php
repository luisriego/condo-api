<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211024184050 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add due and regarding to movement table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE movement ADD due_on DATETIME DEFAULT NULL, ADD regarding DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE movement DROP due_on, DROP regarding');
    }
}

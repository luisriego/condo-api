<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211005185425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_condo DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE user_condo ADD PRIMARY KEY (condo_id, user_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_condo DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE user_condo ADD PRIMARY KEY (user_id, condo_id)');
    }
}

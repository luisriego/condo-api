<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211008233813 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates table `account` and its relationships with `condo`';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE account (id CHAR(36) NOT NULL, condo_id CHAR(36) NOT NULL, name VARCHAR(50) NOT NULL, created_on DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_on DATETIME NOT NULL, INDEX IDX_account_condo_id (condo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE account ADD CONSTRAINT FK_account_condo_id FOREIGN KEY (condo_id) REFERENCES condo (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE account');
    }
}

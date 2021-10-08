<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20211008135646 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create `category` table and its relationships with `condo`';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE category (id CHAR(36) NOT NULL, condo_id CHAR(36) NOT NULL, name VARCHAR(50) NOT NULL, type VARCHAR(15) NOT NULL, created_on DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_on DATETIME NOT NULL, INDEX IDX_category_condo_id (condo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_category_condo_id FOREIGN KEY (condo_id) REFERENCES condo (id)');
        $this->addSql('ALTER TABLE user DROP avatar');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE category');
        $this->addSql('ALTER TABLE user ADD avatar VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}

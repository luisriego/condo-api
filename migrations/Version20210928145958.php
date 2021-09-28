<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210928145958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create the `condo` table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE condo (id CHAR(36) NOT NULL, cnpj VARCHAR(14) NOT NULL, fantasy_name VARCHAR(60) NOT NULL, is_active TINYINT(1) NOT NULL, updated_on DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_on DATETIME NOT NULL, UNIQUE INDEX U_condo_cnpj (cnpj), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE condo');
    }
}

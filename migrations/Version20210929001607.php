<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210929001607 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create the `user_condo` table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE user_condo (user_id CHAR(36) NOT NULL, condo_id CHAR(36) NOT NULL, INDEX IDX_7E2D2CDA76ED395 (user_id), INDEX IDX_7E2D2CDE2B100ED (condo_id), PRIMARY KEY(user_id, condo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_condo ADD CONSTRAINT FK_7E2D2CDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_condo ADD CONSTRAINT FK_7E2D2CDE2B100ED FOREIGN KEY (condo_id) REFERENCES condo (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE user_condo');
    }
}

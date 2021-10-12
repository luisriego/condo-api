<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211011180909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates `movement` table and its relationships';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE movement (id CHAR(36) NOT NULL, category_id CHAR(36) NOT NULL, account_id CHAR(36) NOT NULL, condo_id CHAR(36) NOT NULL, user_id CHAR(36) NOT NULL, amount INT NOT NULL, file_path VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) NOT NULL, created_on DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_on DATETIME NOT NULL, INDEX IDX_movement_category_id (category_id), INDEX IDX_movement_account_id (account_id), INDEX IDX_movement_condo_id (condo_id), INDEX IDX_movement_user_id (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movement ADD CONSTRAINT FK_movement_category_id FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE movement ADD CONSTRAINT FK_movement_account_id FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE movement ADD CONSTRAINT FK_movement_condo_id FOREIGN KEY (condo_id) REFERENCES condo (id)');
        $this->addSql('ALTER TABLE movement ADD CONSTRAINT FK_movement_user_id FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE movement');
    }
}

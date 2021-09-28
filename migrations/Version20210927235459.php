<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210927235459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates condo table with his relationship with user';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE condo (id CHAR(36) NOT NULL, cnpj VARCHAR(14) NOT NULL, fantasy_name VARCHAR(50) NOT NULL, is_active TINYINT(1) NOT NULL, created_on DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_on DATETIME NOT NULL, UNIQUE INDEX U_condo_cnpj (cnpj), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_condo (user_id CHAR(36) NOT NULL, condo_id CHAR(36) NOT NULL, INDEX IDX_user_condo_user_id (user_id), INDEX IDX_user_condo_condo_id (condo_id), PRIMARY KEY(user_id, condo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_condo ADD CONSTRAINT FK_user_condo_user_id FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_condo ADD CONSTRAINT FK_user_condo_condo_id FOREIGN KEY (condo_id) REFERENCES condo (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users_condos DROP FOREIGN KEY FK_user_condo_condo_id');
        $this->addSql('ALTER TABLE users_condos DROP FOREIGN KEY FK_user_condo_user_id');
        $this->addSql('DROP TABLE condo');
        $this->addSql('DROP TABLE users_condos');
    }
}

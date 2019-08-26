<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190820143010 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE actu (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE actu_user (actu_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A6291F14F77EEF58 (actu_id), INDEX IDX_A6291F14A76ED395 (user_id), PRIMARY KEY(actu_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE actu_user ADD CONSTRAINT FK_A6291F14F77EEF58 FOREIGN KEY (actu_id) REFERENCES actu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE actu_user ADD CONSTRAINT FK_A6291F14A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE actu_user DROP FOREIGN KEY FK_A6291F14F77EEF58');
        $this->addSql('DROP TABLE actu');
        $this->addSql('DROP TABLE actu_user');
    }
}

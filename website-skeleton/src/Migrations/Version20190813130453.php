<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190813130453 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, artist_id_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, place VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price INT NOT NULL, INDEX IDX_3BAE0AA71F48AE04 (artist_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE support (id INT AUTO_INCREMENT NOT NULL, product_id_id INT DEFAULT NULL, type_support VARCHAR(255) NOT NULL, price INT NOT NULL, INDEX IDX_8004EBA5DE18E50B (product_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE command_details (id INT AUTO_INCREMENT NOT NULL, command_number_id INT DEFAULT NULL, support_id_id INT DEFAULT NULL, INDEX IDX_9D4C5869B790911B (command_number_id), INDEX IDX_9D4C58698DFE888F (support_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, artist_id_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, production_date DATETIME NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_D34A04AD1F48AE04 (artist_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE streaming (id INT AUTO_INCREMENT NOT NULL, product_id_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, price INT NOT NULL, quality VARCHAR(255) NOT NULL, INDEX IDX_26431861DE18E50B (product_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE streaming_user (streaming_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_504B3762429AEC72 (streaming_id), INDEX IDX_504B3762A76ED395 (user_id), PRIMARY KEY(streaming_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role INT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, collection LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artist (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, style VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE command (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, command_number INT NOT NULL, command_date DATETIME NOT NULL, total_price INT NOT NULL, INDEX IDX_8ECAEAD49D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA71F48AE04 FOREIGN KEY (artist_id_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE support ADD CONSTRAINT FK_8004EBA5DE18E50B FOREIGN KEY (product_id_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE command_details ADD CONSTRAINT FK_9D4C5869B790911B FOREIGN KEY (command_number_id) REFERENCES command (id)');
        $this->addSql('ALTER TABLE command_details ADD CONSTRAINT FK_9D4C58698DFE888F FOREIGN KEY (support_id_id) REFERENCES support (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD1F48AE04 FOREIGN KEY (artist_id_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE streaming ADD CONSTRAINT FK_26431861DE18E50B FOREIGN KEY (product_id_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE streaming_user ADD CONSTRAINT FK_504B3762429AEC72 FOREIGN KEY (streaming_id) REFERENCES streaming (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE streaming_user ADD CONSTRAINT FK_504B3762A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD49D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE command_details DROP FOREIGN KEY FK_9D4C58698DFE888F');
        $this->addSql('ALTER TABLE support DROP FOREIGN KEY FK_8004EBA5DE18E50B');
        $this->addSql('ALTER TABLE streaming DROP FOREIGN KEY FK_26431861DE18E50B');
        $this->addSql('ALTER TABLE streaming_user DROP FOREIGN KEY FK_504B3762429AEC72');
        $this->addSql('ALTER TABLE streaming_user DROP FOREIGN KEY FK_504B3762A76ED395');
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD49D86650F');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA71F48AE04');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD1F48AE04');
        $this->addSql('ALTER TABLE command_details DROP FOREIGN KEY FK_9D4C5869B790911B');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE support');
        $this->addSql('DROP TABLE command_details');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE streaming');
        $this->addSql('DROP TABLE streaming_user');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE command');
    }
}

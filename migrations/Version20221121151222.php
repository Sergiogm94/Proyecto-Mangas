<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221121151222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE characters (id INT AUTO_INCREMENT NOT NULL, manga_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_3A29410E7B6461 (manga_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410E7B6461 FOREIGN KEY (manga_id) REFERENCES mangas (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE characters DROP FOREIGN KEY FK_3A29410E7B6461');
        $this->addSql('DROP TABLE characters');
    }
}

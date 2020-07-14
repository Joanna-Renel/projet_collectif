<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200714112219 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, commentaire LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE docs (id INT AUTO_INCREMENT NOT NULL, document VARCHAR(255) NOT NULL, taille VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, date_edition DATETIME NOT NULL, date_echeance DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, document_id INT DEFAULT NULL, commentaire_id INT NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, premium VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', INDEX IDX_1D1C63B3C33F7837 (document_id), INDEX IDX_1D1C63B3BA9CD190 (commentaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3C33F7837 FOREIGN KEY (document_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3BA9CD190 FOREIGN KEY (commentaire_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3C33F7837');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3BA9CD190');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE docs');
        $this->addSql('DROP TABLE utilisateur');
    }
}

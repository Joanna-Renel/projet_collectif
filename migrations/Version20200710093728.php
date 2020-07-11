<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200710093728 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, pseudo VARCHAR(45) NOT NULL, created_at DATETIME NOT NULL, commentaire LONGTEXT NOT NULL, INDEX IDX_5F9E962AFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE docs (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, document VARCHAR(255) NOT NULL, taille VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, date_edition DATETIME NOT NULL, date_echeance DATETIME NOT NULL, INDEX IDX_51572BB7FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, prenom VARCHAR(45) NOT NULL, nom VARCHAR(45) NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(100) NOT NULL, adresse VARCHAR(255) NOT NULL, password VARCHAR(45) NOT NULL, premium VARCHAR(45) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE docs ADD CONSTRAINT FK_51572BB7FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AFB88E14F');
        $this->addSql('ALTER TABLE docs DROP FOREIGN KEY FK_51572BB7FB88E14F');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE docs');
        $this->addSql('DROP TABLE utilisateur');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200704194546 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, prenom VARCHAR(45) NOT NULL, nom VARCHAR(45) NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(100) NOT NULL, adresse VARCHAR(255) NOT NULL, password VARCHAR(45) NOT NULL, premium VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE docs ADD utilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE docs ADD CONSTRAINT FK_51572BB7FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_51572BB7FB88E14F ON docs (utilisateur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE docs DROP FOREIGN KEY FK_51572BB7FB88E14F');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP INDEX IDX_51572BB7FB88E14F ON docs');
        $this->addSql('ALTER TABLE docs DROP utilisateur_id');
    }
}

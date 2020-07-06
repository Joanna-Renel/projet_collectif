<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200706094833 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE docs DROP FOREIGN KEY FK_51572BB7FB88E14F');
        $this->addSql('DROP INDEX IDX_51572BB7FB88E14F ON docs');
        $this->addSql('ALTER TABLE docs DROP utilisateur_id');
        $this->addSql('ALTER TABLE utilisateur CHANGE premium premium VARCHAR(45) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE docs ADD utilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE docs ADD CONSTRAINT FK_51572BB7FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_51572BB7FB88E14F ON docs (utilisateur_id)');
        $this->addSql('ALTER TABLE utilisateur CHANGE premium premium VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}

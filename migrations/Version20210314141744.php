<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210314141744 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personne CHANGE type type VARCHAR(60) NOT NULL');
        $this->addSql('ALTER TABLE serie ADD scenariste_id INT DEFAULT NULL, ADD dessinateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE serie ADD CONSTRAINT FK_AA3A93341674CEC6 FOREIGN KEY (scenariste_id) REFERENCES personne (id)');
        $this->addSql('ALTER TABLE serie ADD CONSTRAINT FK_AA3A9334EF0AD3BC FOREIGN KEY (dessinateur_id) REFERENCES personne (id)');
        $this->addSql('CREATE INDEX IDX_AA3A93341674CEC6 ON serie (scenariste_id)');
        $this->addSql('CREATE INDEX IDX_AA3A9334EF0AD3BC ON serie (dessinateur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personne CHANGE type type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE serie DROP FOREIGN KEY FK_AA3A93341674CEC6');
        $this->addSql('ALTER TABLE serie DROP FOREIGN KEY FK_AA3A9334EF0AD3BC');
        $this->addSql('DROP INDEX IDX_AA3A93341674CEC6 ON serie');
        $this->addSql('DROP INDEX IDX_AA3A9334EF0AD3BC ON serie');
        $this->addSql('ALTER TABLE serie DROP scenariste_id, DROP dessinateur_id');
    }
}

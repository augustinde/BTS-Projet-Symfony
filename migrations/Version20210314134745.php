<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210314134745 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commenter (membre_id INT NOT NULL, manga_id INT NOT NULL, commentaire LONGTEXT NOT NULL, note DOUBLE PRECISION NOT NULL, posted_at DATETIME NOT NULL, INDEX IDX_AB751D0A6A99F74A (membre_id), INDEX IDX_AB751D0A7B6461 (manga_id), PRIMARY KEY(membre_id, manga_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commenter ADD CONSTRAINT FK_AB751D0A6A99F74A FOREIGN KEY (membre_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE commenter ADD CONSTRAINT FK_AB751D0A7B6461 FOREIGN KEY (manga_id) REFERENCES manga (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE commenter');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210403152512 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commenter DROP FOREIGN KEY FK_AB751D0A6A99F74A');
        $this->addSql('DROP INDEX IDX_AB751D0A6A99F74A ON commenter');
        $this->addSql('ALTER TABLE commenter CHANGE membre_id utilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE commenter ADD CONSTRAINT FK_AB751D0AFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_AB751D0AFB88E14F ON commenter (utilisateur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commenter DROP FOREIGN KEY FK_AB751D0AFB88E14F');
        $this->addSql('DROP INDEX IDX_AB751D0AFB88E14F ON commenter');
        $this->addSql('ALTER TABLE commenter CHANGE utilisateur_id membre_id INT NOT NULL');
        $this->addSql('ALTER TABLE commenter ADD CONSTRAINT FK_AB751D0A6A99F74A FOREIGN KEY (membre_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_AB751D0A6A99F74A ON commenter (membre_id)');
    }
}

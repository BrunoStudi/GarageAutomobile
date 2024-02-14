<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240213062119 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formulaire_contact ADD formulairecontactid INT DEFAULT NULL');
        $this->addSql('ALTER TABLE formulaire_contact ADD CONSTRAINT FK_69601E3DE446A5F FOREIGN KEY (formulairecontactid) REFERENCES voiture (id)');
        $this->addSql('CREATE INDEX IDX_69601E3DE446A5F ON formulaire_contact (formulairecontactid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formulaire_contact DROP FOREIGN KEY FK_69601E3DE446A5F');
        $this->addSql('DROP INDEX IDX_69601E3DE446A5F ON formulaire_contact');
        $this->addSql('ALTER TABLE formulaire_contact DROP formulairecontactid');
    }
}

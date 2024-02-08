<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240208164324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formulaire_contact ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD num_tel INT NOT NULL, ADD message VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE horaires_ouverture ADD jour VARCHAR(255) NOT NULL, ADD horaire VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE temoignage ADD nom VARCHAR(255) NOT NULL, ADD commentaire VARCHAR(255) NOT NULL, ADD note INT NOT NULL');
        $this->addSql('ALTER TABLE voiture ADD id_voiture INT NOT NULL, ADD prix DOUBLE PRECISION NOT NULL, ADD image_url VARCHAR(255) NOT NULL, ADD annee_circulation DATE NOT NULL, ADD kilometrage DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formulaire_contact DROP nom, DROP prenom, DROP email, DROP num_tel, DROP message');
        $this->addSql('ALTER TABLE horaires_ouverture DROP jour, DROP horaire');
        $this->addSql('ALTER TABLE temoignage DROP nom, DROP commentaire, DROP note');
        $this->addSql('ALTER TABLE voiture DROP id_voiture, DROP prix, DROP image_url, DROP annee_circulation, DROP kilometrage');
    }
}

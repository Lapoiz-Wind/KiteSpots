<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260729155352 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE spot (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, code_spot VARCHAR(20) NOT NULL, nom VARCHAR(255) NOT NULL, region VARCHAR(255) DEFAULT NULL, code_region VARCHAR(20) DEFAULT NULL, note DOUBLE PRECISION DEFAULT NULL, short_description CLOB DEFAULT NULL, description CLOB DEFAULT NULL, localisation CLOB DEFAULT NULL, dist_from_paris VARCHAR(255) DEFAULT NULL, dist_from_paris_autoroute VARCHAR(255) DEFAULT NULL, time_from_paris VARCHAR(255) DEFAULT NULL, peage_from_paris VARCHAR(255) DEFAULT NULL, maree_desc CLOB DEFAULT NULL, orientation_desc CLOB DEFAULT NULL, is_foil BOOLEAN NOT NULL, foil_desc CLOB DEFAULT NULL, wave_desc CLOB DEFAULT NULL, is_contraint_ete BOOLEAN NOT NULL, contraint_ete_desc CLOB DEFAULT NULL, long DOUBLE PRECISION DEFAULT NULL, lat DOUBLE PRECISION DEFAULT NULL, windfinder VARCHAR(500) DEFAULT NULL, windguru VARCHAR(500) DEFAULT NULL, meteo_france VARCHAR(500) DEFAULT NULL, meteo_consult VARCHAR(500) DEFAULT NULL, allo_surf VARCHAR(500) DEFAULT NULL, merteo VARCHAR(500) DEFAULT NULL, temp_eau VARCHAR(500) DEFAULT NULL, webcam VARCHAR(500) DEFAULT NULL, balise VARCHAR(500) DEFAULT NULL, maree VARCHAR(500) DEFAULT NULL, orientations CLOB NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B9327A738FD910B2 ON spot (code_spot)');
        $this->addSql('CREATE TABLE spot_link (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, url VARCHAR(500) NOT NULL, titre VARCHAR(255) DEFAULT NULL, commentaire CLOB DEFAULT NULL, position INTEGER NOT NULL, spot_id INTEGER NOT NULL, CONSTRAINT FK_C39117022DF1D37C FOREIGN KEY (spot_id) REFERENCES spot (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_C39117022DF1D37C ON spot_link (spot_id)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 ON messenger_messages (queue_name, available_at, delivered_at, id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE spot');
        $this->addSql('DROP TABLE spot_link');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260731000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add tidal constraint columns (top, ok, warn, ko) to spot table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE spot ADD top DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE spot ADD ok DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE spot ADD warn DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE spot ADD ko DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE spot DROP COLUMN top');
        $this->addSql('ALTER TABLE spot DROP COLUMN ok');
        $this->addSql('ALTER TABLE spot DROP COLUMN warn');
        $this->addSql('ALTER TABLE spot DROP COLUMN ko');
    }
}

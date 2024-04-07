<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240405093451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clientes ADD eliminado TINYINT(1) NOT NULL, CHANGE dni dni VARCHAR(9) DEFAULT NULL, CHANGE apellido apellido VARCHAR(10) DEFAULT NULL, CHANGE nombre nombre VARCHAR(10) DEFAULT NULL, CHANGE telefono telefono VARCHAR(10) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clientes DROP eliminado, CHANGE dni dni VARCHAR(9) NOT NULL, CHANGE apellido apellido VARCHAR(10) NOT NULL, CHANGE nombre nombre VARCHAR(10) NOT NULL, CHANGE telefono telefono VARCHAR(10) NOT NULL');
    }
}

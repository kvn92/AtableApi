<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241226180856 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE difficulte (id INT AUTO_INCREMENT NOT NULL, difficultes VARCHAR(50) NOT NULL, statut_difficultes TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_AF6A33A0CD7706D0 (difficultes), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_repas (id INT AUTO_INCREMENT NOT NULL, type_repas VARCHAR(50) NOT NULL, statut_type_repas TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_A6DFD644A6DFD644 (type_repas), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE difficulte');
        $this->addSql('DROP TABLE type_repas');
    }
}

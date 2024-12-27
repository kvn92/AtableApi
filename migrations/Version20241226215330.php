<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241226215330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recette (id INT AUTO_INCREMENT NOT NULL, categories_id INT DEFAULT NULL, difficultes_id INT DEFAULT NULL, repas_id INT DEFAULT NULL, titre_recettes VARCHAR(50) NOT NULL, preparations LONGTEXT NOT NULL, nbr_likes INT DEFAULT NULL, statut_recettes TINYINT(1) NOT NULL, date_recettes DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_49BB63903E53BD40 (titre_recettes), INDEX IDX_49BB6390A21214B7 (categories_id), INDEX IDX_49BB639073F3B3D4 (difficultes_id), INDEX IDX_49BB63901D236AAA (repas_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB6390A21214B7 FOREIGN KEY (categories_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB639073F3B3D4 FOREIGN KEY (difficultes_id) REFERENCES difficulte (id)');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB63901D236AAA FOREIGN KEY (repas_id) REFERENCES type_repas (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB6390A21214B7');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB639073F3B3D4');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB63901D236AAA');
        $this->addSql('DROP TABLE recette');
    }
}

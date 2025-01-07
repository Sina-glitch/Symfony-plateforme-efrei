<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250105175056 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidature (id INT AUTO_INCREMENT NOT NULL, benevole_id INT DEFAULT NULL, offre_id INT DEFAULT NULL, status VARCHAR(20) NOT NULL, INDEX IDX_E33BD3B8E77B7C09 (benevole_id), INDEX IDX_E33BD3B84CC8505A (offre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre (id INT AUTO_INCREMENT NOT NULL, association_id INT NOT NULL, titre VARCHAR(100) NOT NULL, description VARCHAR(255) DEFAULT NULL, lieu VARCHAR(100) NOT NULL, date_debut DATE NOT NULL, INDEX IDX_AF86866FEFB9C8A5 (association_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B8E77B7C09 FOREIGN KEY (benevole_id) REFERENCES benevole (id)');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B84CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FEFB9C8A5 FOREIGN KEY (association_id) REFERENCES association (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B8E77B7C09');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B84CC8505A');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FEFB9C8A5');
        $this->addSql('DROP TABLE candidature');
        $this->addSql('DROP TABLE offre');
    }
}

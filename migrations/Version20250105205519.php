<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250105205519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B8E77B7C09');
        $this->addSql('ALTER TABLE candidature CHANGE benevole_id benevole_id INT NOT NULL, CHANGE offre_id offre_id INT NOT NULL, CHANGE status statut VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B8E77B7C09 FOREIGN KEY (benevole_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY fk_offre_association');
        $this->addSql('ALTER TABLE offre CHANGE titre titre VARCHAR(255) NOT NULL, CHANGE description description VARCHAR(255) NOT NULL, CHANGE lieu lieu VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FEFB9C8A5 FOREIGN KEY (association_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B8E77B7C09');
        $this->addSql('ALTER TABLE candidature CHANGE benevole_id benevole_id INT DEFAULT NULL, CHANGE offre_id offre_id INT DEFAULT NULL, CHANGE statut status VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B8E77B7C09 FOREIGN KEY (benevole_id) REFERENCES benevole (id)');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FEFB9C8A5');
        $this->addSql('ALTER TABLE offre CHANGE titre titre VARCHAR(100) NOT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE lieu lieu VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT fk_offre_association FOREIGN KEY (association_id) REFERENCES association (id) ON DELETE CASCADE');
    }
}

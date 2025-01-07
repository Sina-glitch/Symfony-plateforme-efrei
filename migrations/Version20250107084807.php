<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250107084807 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_CANDIDATURE_USER_ID');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_CANDIDATURE_USER');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_CANDIDATURE_USER_ID');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_CANDIDATURE_USER');
        $this->addSql('ALTER TABLE candidature DROP status, CHANGE offre_id offre_id INT NOT NULL, CHANGE statut statut VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('DROP INDEX idx_e33bd3b8e77b7c09 ON candidature');
        $this->addSql('CREATE INDEX IDX_E33BD3B8A76ED395 ON candidature (user_id)');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_CANDIDATURE_USER_ID FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_CANDIDATURE_USER FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY fk_offre_association');
        $this->addSql('ALTER TABLE offre CHANGE titre titre VARCHAR(255) NOT NULL, CHANGE description description VARCHAR(255) NOT NULL, CHANGE lieu lieu VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FEFB9C8A5 FOREIGN KEY (association_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD roles JSON NOT NULL COMMENT \'(DC2Type:json)\', DROP role');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B8A76ED395');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B8A76ED395');
        $this->addSql('ALTER TABLE candidature ADD status VARCHAR(20) NOT NULL, CHANGE offre_id offre_id INT DEFAULT NULL, CHANGE statut statut VARCHAR(20) DEFAULT \'En attente\' NOT NULL');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_CANDIDATURE_USER_ID FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_CANDIDATURE_USER FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('DROP INDEX idx_e33bd3b8a76ed395 ON candidature');
        $this->addSql('CREATE INDEX IDX_E33BD3B8E77B7C09 ON candidature (user_id)');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FEFB9C8A5');
        $this->addSql('ALTER TABLE offre CHANGE titre titre VARCHAR(100) NOT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE lieu lieu VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT fk_offre_association FOREIGN KEY (association_id) REFERENCES association (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD role VARCHAR(50) NOT NULL, DROP roles');
    }
}

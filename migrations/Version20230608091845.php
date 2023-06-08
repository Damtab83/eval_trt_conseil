<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230608091845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notice ADD recruteur_id INT NOT NULL');
        $this->addSql('ALTER TABLE notice ADD CONSTRAINT FK_480D45C2BB0859F1 FOREIGN KEY (recruteur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_480D45C2BB0859F1 ON notice (recruteur_id)');
        $this->addSql('ALTER TABLE user CHANGE lastname lastname VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notice DROP FOREIGN KEY FK_480D45C2BB0859F1');
        $this->addSql('DROP INDEX IDX_480D45C2BB0859F1 ON notice');
        $this->addSql('ALTER TABLE notice DROP recruteur_id');
        $this->addSql('ALTER TABLE user CHANGE lastname lastname VARCHAR(255) NOT NULL');
    }
}

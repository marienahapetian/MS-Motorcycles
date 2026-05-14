<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260512200622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feature_value ADD value VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product_features ADD CONSTRAINT FK_7470B6844584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE product_features ADD CONSTRAINT FK_7470B68460E4B879 FOREIGN KEY (feature_id) REFERENCES features (id)');
        $this->addSql('CREATE INDEX IDX_7470B6844584665A ON product_features (product_id)');
        $this->addSql('CREATE INDEX IDX_7470B68460E4B879 ON product_features (feature_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feature_value DROP value');
        $this->addSql('ALTER TABLE product_features DROP FOREIGN KEY FK_7470B6844584665A');
        $this->addSql('ALTER TABLE product_features DROP FOREIGN KEY FK_7470B68460E4B879');
        $this->addSql('DROP INDEX IDX_7470B6844584665A ON product_features');
        $this->addSql('DROP INDEX IDX_7470B68460E4B879 ON product_features');
    }
}

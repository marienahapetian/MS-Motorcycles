<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260502230117 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE feature_category (feature_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_7FA1B6FE60E4B879 (feature_id), INDEX IDX_7FA1B6FE12469DE2 (category_id), PRIMARY KEY (feature_id, category_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE feature_category ADD CONSTRAINT FK_7FA1B6FE60E4B879 FOREIGN KEY (feature_id) REFERENCES features (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE feature_category ADD CONSTRAINT FK_7FA1B6FE12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feature_category DROP FOREIGN KEY FK_7FA1B6FE60E4B879');
        $this->addSql('ALTER TABLE feature_category DROP FOREIGN KEY FK_7FA1B6FE12469DE2');
        $this->addSql('DROP TABLE feature_category');
    }
}

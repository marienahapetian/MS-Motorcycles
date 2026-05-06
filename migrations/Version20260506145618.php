<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260506145618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brand_category (brand_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_C17C8AD044F5D008 (brand_id), INDEX IDX_C17C8AD012469DE2 (category_id), PRIMARY KEY (brand_id, category_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE brand_category ADD CONSTRAINT FK_C17C8AD044F5D008 FOREIGN KEY (brand_id) REFERENCES brands (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brand_category ADD CONSTRAINT FK_C17C8AD012469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brands CHANGE created_at created_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brand_category DROP FOREIGN KEY FK_C17C8AD044F5D008');
        $this->addSql('ALTER TABLE brand_category DROP FOREIGN KEY FK_C17C8AD012469DE2');
        $this->addSql('DROP TABLE brand_category');
        $this->addSql('ALTER TABLE brands CHANGE created_at created_at DATETIME DEFAULT NULL');
    }
}

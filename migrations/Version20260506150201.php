<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260506150201 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brands DROP FOREIGN KEY `FK_7EA2443412469DE2`');
        $this->addSql('DROP INDEX IDX_7EA2443412469DE2 ON brands');
        $this->addSql('ALTER TABLE brands DROP category_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brands ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE brands ADD CONSTRAINT `FK_7EA2443412469DE2` FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_7EA2443412469DE2 ON brands (category_id)');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260503163948 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_feature_product (product_feature_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_D0D69A39F383E752 (product_feature_id), INDEX IDX_D0D69A394584665A (product_id), PRIMARY KEY (product_feature_id, product_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE product_feature_product ADD CONSTRAINT FK_D0D69A39F383E752 FOREIGN KEY (product_feature_id) REFERENCES product_features (id)');
        $this->addSql('ALTER TABLE product_feature_product ADD CONSTRAINT FK_D0D69A394584665A FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_features DROP product_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_feature_product DROP FOREIGN KEY FK_D0D69A39F383E752');
        $this->addSql('ALTER TABLE product_feature_product DROP FOREIGN KEY FK_D0D69A394584665A');
        $this->addSql('DROP TABLE product_feature_product');
        $this->addSql('ALTER TABLE product_features ADD product_id BIGINT NOT NULL');
    }
}

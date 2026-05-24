<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260524221425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brands (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE brand_category (brand_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_C17C8AD044F5D008 (brand_id), INDEX IDX_C17C8AD012469DE2 (category_id), PRIMARY KEY (brand_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, icon VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE category_product (category_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_149244D312469DE2 (category_id), INDEX IDX_149244D34584665A (product_id), PRIMARY KEY (category_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE feature_value (id INT AUTO_INCREMENT NOT NULL, value VARCHAR(255) NOT NULL, feature_id INT NOT NULL, INDEX IDX_D429523D60E4B879 (feature_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE features (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(20) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE feature_category (feature_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_7FA1B6FE60E4B879 (feature_id), INDEX IDX_7FA1B6FE12469DE2 (category_id), PRIMARY KEY (feature_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE messages (id INT AUTO_INCREMENT NOT NULL, sender VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, subject VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, sent DATETIME NOT NULL, seen TINYINT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE product_features (id INT AUTO_INCREMENT NOT NULL, value VARCHAR(255) NOT NULL, product_id INT NOT NULL, feature_id INT NOT NULL, INDEX IDX_7470B6844584665A (product_id), INDEX IDX_7470B68460E4B879 (feature_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE product_images (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) NOT NULL, is_main TINYINT NOT NULL, product_id INT NOT NULL, INDEX IDX_8263FFCE4584665A (product_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, year INT DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, description LONGTEXT NOT NULL, added DATETIME NOT NULL, modified DATETIME DEFAULT NULL, brand_id INT NOT NULL, INDEX IDX_B3BA5A5A44F5D008 (brand_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles TEXT NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE website_settings (id INT AUTO_INCREMENT NOT NULL, instagram_link VARCHAR(255) DEFAULT NULL, facebook_link VARCHAR(255) DEFAULT NULL, tiktok_link VARCHAR(255) DEFAULT NULL, font VARCHAR(255) NOT NULL, accent_color VARCHAR(255) NOT NULL, black_color VARCHAR(255) NOT NULL, white_color VARCHAR(255) NOT NULL, location LONGTEXT NOT NULL, address VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE brand_category ADD CONSTRAINT FK_C17C8AD044F5D008 FOREIGN KEY (brand_id) REFERENCES brands (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brand_category ADD CONSTRAINT FK_C17C8AD012469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_product ADD CONSTRAINT FK_149244D312469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_product ADD CONSTRAINT FK_149244D34584665A FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE feature_value ADD CONSTRAINT FK_D429523D60E4B879 FOREIGN KEY (feature_id) REFERENCES features (id)');
        $this->addSql('ALTER TABLE feature_category ADD CONSTRAINT FK_7FA1B6FE60E4B879 FOREIGN KEY (feature_id) REFERENCES features (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE feature_category ADD CONSTRAINT FK_7FA1B6FE12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_features ADD CONSTRAINT FK_7470B6844584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE product_features ADD CONSTRAINT FK_7470B68460E4B879 FOREIGN KEY (feature_id) REFERENCES features (id)');
        $this->addSql('ALTER TABLE product_images ADD CONSTRAINT FK_8263FFCE4584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A44F5D008 FOREIGN KEY (brand_id) REFERENCES brands (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brand_category DROP FOREIGN KEY FK_C17C8AD044F5D008');
        $this->addSql('ALTER TABLE brand_category DROP FOREIGN KEY FK_C17C8AD012469DE2');
        $this->addSql('ALTER TABLE category_product DROP FOREIGN KEY FK_149244D312469DE2');
        $this->addSql('ALTER TABLE category_product DROP FOREIGN KEY FK_149244D34584665A');
        $this->addSql('ALTER TABLE feature_value DROP FOREIGN KEY FK_D429523D60E4B879');
        $this->addSql('ALTER TABLE feature_category DROP FOREIGN KEY FK_7FA1B6FE60E4B879');
        $this->addSql('ALTER TABLE feature_category DROP FOREIGN KEY FK_7FA1B6FE12469DE2');
        $this->addSql('ALTER TABLE product_features DROP FOREIGN KEY FK_7470B6844584665A');
        $this->addSql('ALTER TABLE product_features DROP FOREIGN KEY FK_7470B68460E4B879');
        $this->addSql('ALTER TABLE product_images DROP FOREIGN KEY FK_8263FFCE4584665A');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A44F5D008');
        $this->addSql('DROP TABLE brands');
        $this->addSql('DROP TABLE brand_category');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE category_product');
        $this->addSql('DROP TABLE feature_value');
        $this->addSql('DROP TABLE features');
        $this->addSql('DROP TABLE feature_category');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP TABLE product_features');
        $this->addSql('DROP TABLE product_images');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE website_settings');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260502214404 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brands (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, category_id INT NOT NULL, INDEX IDX_7EA2443412469DE2 (category_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, icon VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE features (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messages (id INT AUTO_INCREMENT NOT NULL, sender VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, subject VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, sent DATETIME NOT NULL, seen TINYINT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE product_features (id INT AUTO_INCREMENT NOT NULL, product_id BIGINT NOT NULL, feature_id BIGINT NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE product_images (id INT AUTO_INCREMENT NOT NULL, product_id BIGINT NOT NULL, image VARCHAR(255) NOT NULL, is_main TINYINT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, year INT DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, description LONGTEXT NOT NULL, added DATETIME NOT NULL, modified DATETIME DEFAULT NULL, brand_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_B3BA5A5A44F5D008 (brand_id), INDEX IDX_B3BA5A5A12469DE2 (category_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE website_settings (id INT AUTO_INCREMENT NOT NULL, instagram_link VARCHAR(255) DEFAULT NULL, tweeter_link VARCHAR(255) DEFAULT NULL, tiktok_link VARCHAR(255) DEFAULT NULL, font VARCHAR(255) NOT NULL, accent_color VARCHAR(255) NOT NULL, black_color VARCHAR(255) NOT NULL, white_color VARCHAR(255) NOT NULL, location LONGTEXT NOT NULL, address VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE brands ADD CONSTRAINT FK_7EA2443412469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A44F5D008 FOREIGN KEY (brand_id) REFERENCES brands (id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brands DROP FOREIGN KEY FK_7EA2443412469DE2');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A44F5D008');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A12469DE2');
        $this->addSql('DROP TABLE brands');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE features');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP TABLE product_features');
        $this->addSql('DROP TABLE product_images');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE website_settings');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241015092357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipment_item (id INT AUTO_INCREMENT NOT NULL, equipment_type_id INT NOT NULL, location_id INT DEFAULT NULL, is_loaned TINYINT(1) NOT NULL, state VARCHAR(255) NOT NULL, INDEX IDX_259FF418B337437C (equipment_type_id), INDEX IDX_259FF41864D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipment_type (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, stock_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, brand VARCHAR(255) NOT NULL, unit_price DOUBLE PRECISION NOT NULL, INDEX IDX_B65A862F12469DE2 (category_id), UNIQUE INDEX UNIQ_B65A862FDCD6110 (stock_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE loan (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, equipment_item_id INT NOT NULL, date_loaned DATE NOT NULL, date_due DATE NOT NULL, INDEX IDX_C5D30D03A76ED395 (user_id), INDEX IDX_C5D30D0364149DB1 (equipment_item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, aisle VARCHAR(255) NOT NULL, shelf INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movement (id INT AUTO_INCREMENT NOT NULL, loan_id INT DEFAULT NULL, repair_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, date DATE NOT NULL, INDEX IDX_F4DD95F7CE73868F (loan_id), INDEX IDX_F4DD95F743833CFF (repair_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, equipment_item_id INT DEFAULT NULL, user_id INT DEFAULT NULL, message LONGTEXT NOT NULL, type VARCHAR(255) NOT NULL, date DATE NOT NULL, INDEX IDX_BF5476CA64149DB1 (equipment_item_id), INDEX IDX_BF5476CAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repair (id INT AUTO_INCREMENT NOT NULL, equipment_item_id INT NOT NULL, description LONGTEXT DEFAULT NULL, cost DOUBLE PRECISION NOT NULL, repair_time VARCHAR(255) NOT NULL COMMENT \'(DC2Type:dateinterval)\', INDEX IDX_8EE4342164149DB1 (equipment_item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, total_quantity INT NOT NULL, available_quantity INT NOT NULL, minimum_stock_level INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE equipment_item ADD CONSTRAINT FK_259FF418B337437C FOREIGN KEY (equipment_type_id) REFERENCES equipment_type (id)');
        $this->addSql('ALTER TABLE equipment_item ADD CONSTRAINT FK_259FF41864D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE equipment_type ADD CONSTRAINT FK_B65A862F12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE equipment_type ADD CONSTRAINT FK_B65A862FDCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D03A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D0364149DB1 FOREIGN KEY (equipment_item_id) REFERENCES equipment_item (id)');
        $this->addSql('ALTER TABLE movement ADD CONSTRAINT FK_F4DD95F7CE73868F FOREIGN KEY (loan_id) REFERENCES loan (id)');
        $this->addSql('ALTER TABLE movement ADD CONSTRAINT FK_F4DD95F743833CFF FOREIGN KEY (repair_id) REFERENCES repair (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA64149DB1 FOREIGN KEY (equipment_item_id) REFERENCES equipment_item (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE repair ADD CONSTRAINT FK_8EE4342164149DB1 FOREIGN KEY (equipment_item_id) REFERENCES equipment_item (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipment_item DROP FOREIGN KEY FK_259FF418B337437C');
        $this->addSql('ALTER TABLE equipment_item DROP FOREIGN KEY FK_259FF41864D218E');
        $this->addSql('ALTER TABLE equipment_type DROP FOREIGN KEY FK_B65A862F12469DE2');
        $this->addSql('ALTER TABLE equipment_type DROP FOREIGN KEY FK_B65A862FDCD6110');
        $this->addSql('ALTER TABLE loan DROP FOREIGN KEY FK_C5D30D03A76ED395');
        $this->addSql('ALTER TABLE loan DROP FOREIGN KEY FK_C5D30D0364149DB1');
        $this->addSql('ALTER TABLE movement DROP FOREIGN KEY FK_F4DD95F7CE73868F');
        $this->addSql('ALTER TABLE movement DROP FOREIGN KEY FK_F4DD95F743833CFF');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA64149DB1');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAA76ED395');
        $this->addSql('ALTER TABLE repair DROP FOREIGN KEY FK_8EE4342164149DB1');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE equipment_item');
        $this->addSql('DROP TABLE equipment_type');
        $this->addSql('DROP TABLE loan');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE movement');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE repair');
        $this->addSql('DROP TABLE stock');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241031162303 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipment_item DROP name');
        $this->addSql('ALTER TABLE repair ADD date_arrival DATE NOT NULL, ADD date_return DATE NOT NULL, DROP description, DROP repair_time');
        $this->addSql('ALTER TABLE user ADD roles JSON NOT NULL, DROP role');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE repair ADD description LONGTEXT DEFAULT NULL, ADD repair_time VARCHAR(255) NOT NULL COMMENT \'(DC2Type:dateinterval)\', DROP date_arrival, DROP date_return');
        $this->addSql('ALTER TABLE equipment_item ADD name VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user ADD role VARCHAR(255) NOT NULL, DROP roles');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210809212658 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `order` ADD billing_address_country_id INT NOT NULL, ADD shipping_address_country_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993987E815CFC FOREIGN KEY (billing_address_country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398BD2914A2 FOREIGN KEY (shipping_address_country_id) REFERENCES country (id)');
        $this->addSql('CREATE INDEX IDX_F52993987E815CFC ON `order` (billing_address_country_id)');
        $this->addSql('CREATE INDEX IDX_F5299398BD2914A2 ON `order` (shipping_address_country_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993987E815CFC');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398BD2914A2');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP INDEX IDX_F52993987E815CFC ON `order`');
        $this->addSql('DROP INDEX IDX_F5299398BD2914A2 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP billing_address_country_id, DROP shipping_address_country_id');
    }
}

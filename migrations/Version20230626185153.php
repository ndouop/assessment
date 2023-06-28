<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230626185153 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create car and car_category table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, nb_doors INT DEFAULT NULL, nb_seats INT DEFAULT NULL, name VARCHAR(255) NOT NULL, cost NUMERIC(12, 2) NOT NULL, color VARCHAR(20) DEFAULT NULL, INDEX IDX_773DE69D12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D12469DE2 FOREIGN KEY (category_id) REFERENCES car_category (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D12469DE2');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE car_category');
    }
}

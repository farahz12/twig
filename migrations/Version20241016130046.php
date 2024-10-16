<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241016130046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE aeroport (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book ADD publication_date VARCHAR(255) DEFAULT NULL, DROP publicationDate, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE title title VARCHAR(255) DEFAULT NULL, CHANGE enabled enabled TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE student CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE aeroport');
        $this->addSql('ALTER TABLE book ADD publicationDate VARCHAR(255) NOT NULL, DROP publication_date, CHANGE id id INT NOT NULL, CHANGE title title VARCHAR(255) NOT NULL, CHANGE enabled enabled TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE student CHANGE id id INT NOT NULL');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241007214727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Add the new columns 'username' and 'email' to the 'author' table
        $this->addSql('ALTER TABLE author ADD username VARCHAR(180) NOT NULL, ADD email VARCHAR(255) NOT NULL');
        
        // Create unique indexes for 'username' and 'email'
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BDAFD8C8F85E0677 ON author (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BDAFD8C8E7927C74 ON author (email)');
    }

    public function down(Schema $schema): void
    {
        // Revert the changes: drop the 'username' and 'email' columns and remove their indexes
        $this->addSql('DROP INDEX UNIQ_BDAFD8C8F85E0677 ON author');
        $this->addSql('DROP INDEX UNIQ_BDAFD8C8E7927C74 ON author');
        $this->addSql('ALTER TABLE author DROP username, DROP email');
    }
}

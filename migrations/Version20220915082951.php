<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220915082951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id uuid NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C15E237E06 ON category (name)');
        $this->addSql('CREATE TABLE memory (id uuid NOT NULL, name VARCHAR(255) NOT NULL, content TEXT NOT NULL, type INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, modified_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN memory.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN memory.modified_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE doctrine_memory_doctrine_category (doctrine_memory_id uuid NOT NULL, doctrine_category_id uuid NOT NULL, PRIMARY KEY(doctrine_memory_id, doctrine_category_id))');
        $this->addSql('CREATE INDEX IDX_9C9618C2A2EFD590 ON doctrine_memory_doctrine_category (doctrine_memory_id)');
        $this->addSql('CREATE INDEX IDX_9C9618C253E0EED4 ON doctrine_memory_doctrine_category (doctrine_category_id)');
        $this->addSql('ALTER TABLE doctrine_memory_doctrine_category ADD CONSTRAINT FK_9C9618C2A2EFD590 FOREIGN KEY (doctrine_memory_id) REFERENCES memory (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE doctrine_memory_doctrine_category ADD CONSTRAINT FK_9C9618C253E0EED4 FOREIGN KEY (doctrine_category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE doctrine_memory_doctrine_category DROP CONSTRAINT FK_9C9618C2A2EFD590');
        $this->addSql('ALTER TABLE doctrine_memory_doctrine_category DROP CONSTRAINT FK_9C9618C253E0EED4');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE memory');
        $this->addSql('DROP TABLE doctrine_memory_doctrine_category');
    }
}

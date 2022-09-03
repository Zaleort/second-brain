<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220901064407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE memory_category (memory_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(memory_id, category_id))');
        $this->addSql('CREATE INDEX IDX_1013917ACCC80CB3 ON memory_category (memory_id)');
        $this->addSql('CREATE INDEX IDX_1013917A12469DE2 ON memory_category (category_id)');
        $this->addSql('ALTER TABLE memory_category ADD CONSTRAINT FK_1013917ACCC80CB3 FOREIGN KEY (memory_id) REFERENCES memory (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE memory_category ADD CONSTRAINT FK_1013917A12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE memory ALTER content TYPE TEXT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('ALTER TABLE memory_category DROP CONSTRAINT FK_1013917ACCC80CB3');
        $this->addSql('ALTER TABLE memory_category DROP CONSTRAINT FK_1013917A12469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE memory_category');
        $this->addSql('ALTER TABLE memory ADD categories TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE memory ALTER content TYPE TEXT');
        $this->addSql('ALTER TABLE memory ALTER content TYPE TEXT');
        $this->addSql('COMMENT ON COLUMN memory.categories IS \'(DC2Type:array)\'');
    }
}

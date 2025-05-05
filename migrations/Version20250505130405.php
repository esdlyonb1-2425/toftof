<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250505130405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE post (id SERIAL NOT NULL, image_id INT NOT NULL, content TEXT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_5A8A6C8D3DA5256D ON post (image_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE post DROP CONSTRAINT FK_5A8A6C8D3DA5256D
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE post
        SQL);
    }
}

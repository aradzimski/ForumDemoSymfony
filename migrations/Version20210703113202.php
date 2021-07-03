<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210703113202 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE forum (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(60) NOT NULL, url_title VARCHAR(60) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL)');
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, topic_id INTEGER NOT NULL, user_id INTEGER NOT NULL, contents CLOB NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, is_edited BOOLEAN NOT NULL)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D1F55203D ON post (topic_id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DA76ED395 ON post (user_id)');
        $this->addSql('CREATE TABLE topic (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, forum_id INTEGER NOT NULL, user_id INTEGER NOT NULL, title VARCHAR(60) NOT NULL, url_title VARCHAR(60) NOT NULL, description VARCHAR(60) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX IDX_9D40DE1B29CCBAD0 ON topic (forum_id)');
        $this->addSql('CREATE INDEX IDX_9D40DE1BA76ED395 ON topic (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE forum');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE topic');
    }
}

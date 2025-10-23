<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251022194243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__event AS SELECT id, user_id, city_id, category_id, legacy_id, description, title, short_description, status, creation_date, update_date, type, start_date, end_date, start_at, end_at FROM event');
        $this->addSql('DROP TABLE event');
        $this->addSql('CREATE TABLE event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, city_id INTEGER NOT NULL, category_id INTEGER DEFAULT NULL, location_id INTEGER DEFAULT NULL, legacy_id INTEGER DEFAULT NULL, description CLOB DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, short_description CLOB DEFAULT NULL, status VARCHAR(20) DEFAULT NULL, creation_date DATETIME NOT NULL, update_date DATETIME DEFAULT NULL, type VARCHAR(20) DEFAULT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, start_at TIME DEFAULT NULL, end_at TIME DEFAULT NULL, CONSTRAINT FK_3BAE0AA7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3BAE0AA78BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3BAE0AA712469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3BAE0AA764D218E FOREIGN KEY (location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO event (id, user_id, city_id, category_id, legacy_id, description, title, short_description, status, creation_date, update_date, type, start_date, end_date, start_at, end_at) SELECT id, user_id, city_id, category_id, legacy_id, description, title, short_description, status, creation_date, update_date, type, start_date, end_date, start_at, end_at FROM __temp__event');
        $this->addSql('DROP TABLE __temp__event');
        $this->addSql('CREATE INDEX IDX_3BAE0AA712469DE2 ON event (category_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA78BAC62AF ON event (city_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7A76ED395 ON event (user_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA764D218E ON event (location_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__event AS SELECT id, user_id, city_id, category_id, legacy_id, description, title, short_description, status, creation_date, update_date, type, start_date, end_date, start_at, end_at FROM event');
        $this->addSql('DROP TABLE event');
        $this->addSql('CREATE TABLE event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, city_id INTEGER NOT NULL, category_id INTEGER DEFAULT NULL, legacy_id INTEGER DEFAULT NULL, description CLOB DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, short_description CLOB DEFAULT NULL, status VARCHAR(20) DEFAULT NULL, creation_date DATETIME NOT NULL, update_date DATETIME DEFAULT NULL, type VARCHAR(20) DEFAULT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, start_at TIME DEFAULT NULL, end_at TIME DEFAULT NULL, CONSTRAINT FK_3BAE0AA7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3BAE0AA78BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3BAE0AA712469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO event (id, user_id, city_id, category_id, legacy_id, description, title, short_description, status, creation_date, update_date, type, start_date, end_date, start_at, end_at) SELECT id, user_id, city_id, category_id, legacy_id, description, title, short_description, status, creation_date, update_date, type, start_date, end_date, start_at, end_at FROM __temp__event');
        $this->addSql('DROP TABLE __temp__event');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7A76ED395 ON event (user_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA78BAC62AF ON event (city_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA712469DE2 ON event (category_id)');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220705112749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE binance_api_keys_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE notification_settings_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE binance_api_keys (id INT NOT NULL, user_id INT NOT NULL, api_key VARCHAR(255) DEFAULT NULL, api_secret VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE notification_settings (id INT NOT NULL, user_id INT NOT NULL, chat_id INT NOT NULL, pair VARCHAR(255) DEFAULT NULL, percentage DOUBLE PRECISION DEFAULT NULL, entry_price DOUBLE PRECISION DEFAULT NULL, end_price DOUBLE PRECISION DEFAULT NULL, is_notified BOOLEAN NOT NULL, is_watching BOOLEAN NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE binance_api_keys_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE notification_settings_id_seq CASCADE');
        $this->addSql('DROP TABLE binance_api_keys');
        $this->addSql('DROP TABLE notification_settings');
    }
}

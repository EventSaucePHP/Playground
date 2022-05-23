<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220523073137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE IF NOT EXISTS reconstitution_storage (
  event_id uuid NOT NULL,
  aggregate_root_id uuid NOT NULL,
  version integer NULL check (version > 0),
  payload varchar NOT NULL,
  PRIMARY KEY (event_id)
);');

        $this->addSql('CREATE INDEX IF NOT EXISTS aggregate_reconstitution ON reconstitution_storage (aggregate_root_id, version ASC)');
        $this->addSql('CREATE TABLE IF NOT EXISTS outbox_messages (
  id bigserial NOT NULL,
  consumed bool NOT NULL DEFAULT false,
  payload varchar NOT NULL,
  PRIMARY KEY (id)
);');
        $this->addSql('CREATE INDEX IF NOT EXISTS outbox_consumption ON outbox_messages (consumed, id ASC);');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS outbox_messages');
        $this->addSql('DROP TABLE IF EXISTS reconstitution_storage');
    }
}

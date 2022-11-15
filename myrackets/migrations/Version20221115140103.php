<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221115140103 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE racket_racket_category (racket_id INTEGER NOT NULL, racket_category_id INTEGER NOT NULL, PRIMARY KEY(racket_id, racket_category_id), CONSTRAINT FK_C7111763D0FF25ED FOREIGN KEY (racket_id) REFERENCES racket (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_C711176396BA6886 FOREIGN KEY (racket_category_id) REFERENCES racket_category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_C7111763D0FF25ED ON racket_racket_category (racket_id)');
        $this->addSql('CREATE INDEX IDX_C711176396BA6886 ON racket_racket_category (racket_category_id)');
        $this->addSql('CREATE TABLE racket_category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, parent_id INTEGER DEFAULT NULL, label VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, CONSTRAINT FK_92862F84727ACA70 FOREIGN KEY (parent_id) REFERENCES racket_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_92862F84727ACA70 ON racket_category (parent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE racket_racket_category');
        $this->addSql('DROP TABLE racket_category');
    }
}

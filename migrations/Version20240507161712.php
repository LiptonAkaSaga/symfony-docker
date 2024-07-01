<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240507161712 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE information_about_me_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE information_about_me (id INT NOT NULL, name VARCHAR(300) NOT NULL, age INT DEFAULT NULL, hobby VARCHAR(300) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE article ALTER date_added DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE information_about_me_id_seq CASCADE');
        $this->addSql('DROP TABLE information_about_me');
        $this->addSql('ALTER TABLE article ALTER date_added SET DEFAULT CURRENT_TIMESTAMP');
    }
}

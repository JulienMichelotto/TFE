<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210816063806 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD gender VARCHAR(4) NOT NULL, ADD phone_number VARCHAR(12) DEFAULT NULL, ADD gsm_number VARCHAR(12) NOT NULL, ADD address VARCHAR(255) NOT NULL, ADD street_number INT NOT NULL, ADD box_number VARCHAR(10) NOT NULL, ADD cgv TINYINT(1) NOT NULL, ADD rgpd TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP gender, DROP phone_number, DROP gsm_number, DROP address, DROP street_number, DROP box_number, DROP cgv, DROP rgpd');
    }
}

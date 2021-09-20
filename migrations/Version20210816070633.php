<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210816070633 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE extra (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE extra_detail (id INT AUTO_INCREMENT NOT NULL, extra_id INT NOT NULL, detail VARCHAR(255) NOT NULL, INDEX IDX_F82A473B2B959FC6 (extra_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, descr VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, city VARCHAR(255) NOT NULL, start DATE NOT NULL, end DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation_detail (id INT AUTO_INCREMENT NOT NULL, formation_id INT NOT NULL, detail VARCHAR(255) NOT NULL, INDEX IDX_E1F71BE5200282E (formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job (id INT AUTO_INCREMENT NOT NULL, descr VARCHAR(255) NOT NULL, society_name VARCHAR(255) DEFAULT NULL, job_city VARCHAR(255) DEFAULT NULL, start DATE NOT NULL, end DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_detail (id INT AUTO_INCREMENT NOT NULL, job_id INT NOT NULL, detail VARCHAR(255) NOT NULL, INDEX IDX_7E025212BE04EA9 (job_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE extra_detail ADD CONSTRAINT FK_F82A473B2B959FC6 FOREIGN KEY (extra_id) REFERENCES extra (id)');
        $this->addSql('ALTER TABLE formation_detail ADD CONSTRAINT FK_E1F71BE5200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE job_detail ADD CONSTRAINT FK_7E025212BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE extra_detail DROP FOREIGN KEY FK_F82A473B2B959FC6');
        $this->addSql('ALTER TABLE formation_detail DROP FOREIGN KEY FK_E1F71BE5200282E');
        $this->addSql('ALTER TABLE job_detail DROP FOREIGN KEY FK_7E025212BE04EA9');
        $this->addSql('DROP TABLE extra');
        $this->addSql('DROP TABLE extra_detail');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE formation_detail');
        $this->addSql('DROP TABLE job');
        $this->addSql('DROP TABLE job_detail');
    }
}

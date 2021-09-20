<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210816080220 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE curiculum ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE curiculum ADD CONSTRAINT FK_91AE568AA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_91AE568AA76ED395 ON curiculum (user_id)');
        $this->addSql('ALTER TABLE extra_detail CHANGE extra_id extra_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE formation_detail CHANGE formation_id formation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE job_detail CHANGE job_id job_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE curiculum DROP FOREIGN KEY FK_91AE568AA76ED395');
        $this->addSql('DROP INDEX IDX_91AE568AA76ED395 ON curiculum');
        $this->addSql('ALTER TABLE curiculum DROP user_id');
        $this->addSql('ALTER TABLE extra_detail CHANGE extra_id extra_id INT NOT NULL');
        $this->addSql('ALTER TABLE formation_detail CHANGE formation_id formation_id INT NOT NULL');
        $this->addSql('ALTER TABLE job_detail CHANGE job_id job_id INT NOT NULL');
    }
}

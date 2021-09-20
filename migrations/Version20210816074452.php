<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210816074452 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE curiculum (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE extra ADD curiculum_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE extra ADD CONSTRAINT FK_4D3F0D65576C2FCA FOREIGN KEY (curiculum_id) REFERENCES curiculum (id)');
        $this->addSql('CREATE INDEX IDX_4D3F0D65576C2FCA ON extra (curiculum_id)');
        $this->addSql('ALTER TABLE formation ADD curiculum_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF576C2FCA FOREIGN KEY (curiculum_id) REFERENCES curiculum (id)');
        $this->addSql('CREATE INDEX IDX_404021BF576C2FCA ON formation (curiculum_id)');
        $this->addSql('ALTER TABLE job ADD curiculum_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F8576C2FCA FOREIGN KEY (curiculum_id) REFERENCES curiculum (id)');
        $this->addSql('CREATE INDEX IDX_FBD8E0F8576C2FCA ON job (curiculum_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE extra DROP FOREIGN KEY FK_4D3F0D65576C2FCA');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF576C2FCA');
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F8576C2FCA');
        $this->addSql('DROP TABLE curiculum');
        $this->addSql('DROP INDEX IDX_4D3F0D65576C2FCA ON extra');
        $this->addSql('ALTER TABLE extra DROP curiculum_id');
        $this->addSql('DROP INDEX IDX_404021BF576C2FCA ON formation');
        $this->addSql('ALTER TABLE formation DROP curiculum_id');
        $this->addSql('DROP INDEX IDX_FBD8E0F8576C2FCA ON job');
        $this->addSql('ALTER TABLE job DROP curiculum_id');
    }
}

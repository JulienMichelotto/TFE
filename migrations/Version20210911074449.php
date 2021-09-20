<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210911074449 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE color (id INT AUTO_INCREMENT NOT NULL, descr VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE color_template (color_id INT NOT NULL, template_id INT NOT NULL, INDEX IDX_4BE584C17ADA1FB5 (color_id), INDEX IDX_4BE584C15DA0FB8 (template_id), PRIMARY KEY(color_id, template_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE template (id INT AUTO_INCREMENT NOT NULL, descr VARCHAR(255) NOT NULL, dark TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE color_template ADD CONSTRAINT FK_4BE584C17ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE color_template ADD CONSTRAINT FK_4BE584C15DA0FB8 FOREIGN KEY (template_id) REFERENCES template (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE curiculum ADD template_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE curiculum ADD CONSTRAINT FK_91AE568A5DA0FB8 FOREIGN KEY (template_id) REFERENCES template (id)');
        $this->addSql('CREATE INDEX IDX_91AE568A5DA0FB8 ON curiculum (template_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE color_template DROP FOREIGN KEY FK_4BE584C17ADA1FB5');
        $this->addSql('ALTER TABLE color_template DROP FOREIGN KEY FK_4BE584C15DA0FB8');
        $this->addSql('ALTER TABLE curiculum DROP FOREIGN KEY FK_91AE568A5DA0FB8');
        $this->addSql('DROP TABLE color');
        $this->addSql('DROP TABLE color_template');
        $this->addSql('DROP TABLE template');
        $this->addSql('DROP INDEX IDX_91AE568A5DA0FB8 ON curiculum');
        $this->addSql('ALTER TABLE curiculum DROP template_id');
    }
}

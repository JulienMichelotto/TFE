<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210830153645 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649C06A9F55');
        $this->addSql('DROP INDEX UNIQ_8D93D649C06A9F55 ON user');
        $this->addSql('ALTER TABLE user DROP img_id, DROP image_name, DROP updated_at');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` ADD img_id INT DEFAULT NULL, ADD image_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649C06A9F55 FOREIGN KEY (img_id) REFERENCES user_img (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649C06A9F55 ON `user` (img_id)');
    }
}

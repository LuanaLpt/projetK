<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260611081639 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE main_image ADD CONSTRAINT FK_6661B719126F525E FOREIGN KEY (item_id) REFERENCES art (id)');
        $this->addSql('ALTER TABLE main_image ADD CONSTRAINT FK_6661B7198C25E51A FOREIGN KEY (art_id) REFERENCES art (id)');
        $this->addSql('ALTER TABLE transi_image ADD CONSTRAINT FK_9265748B126F525E FOREIGN KEY (item_id) REFERENCES art (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE main_image DROP FOREIGN KEY FK_6661B719126F525E');
        $this->addSql('ALTER TABLE main_image DROP FOREIGN KEY FK_6661B7198C25E51A');
        $this->addSql('ALTER TABLE transi_image DROP FOREIGN KEY FK_9265748B126F525E');
    }
}

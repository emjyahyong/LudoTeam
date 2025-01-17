<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250117074637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game ADD type VARCHAR(255) NOT NULL, ADD board_size INT DEFAULT NULL, ADD board_type VARCHAR(255) DEFAULT NULL, ADD number_of_cards INT DEFAULT NULL, ADD card_type VARCHAR(255) DEFAULT NULL, ADD multiple_decks TINYINT(1) DEFAULT NULL, ADD average_duration INT DEFAULT NULL, ADD victory_condition VARCHAR(255) DEFAULT NULL, ADD requires_equipment TINYINT(1) DEFAULT NULL, ADD required_equipment LONGTEXT DEFAULT NULL, ADD contact_level VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP type, DROP board_size, DROP board_type, DROP number_of_cards, DROP card_type, DROP multiple_decks, DROP average_duration, DROP victory_condition, DROP requires_equipment, DROP required_equipment, DROP contact_level');
    }
}

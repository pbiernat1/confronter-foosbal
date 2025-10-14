<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251014154424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table for Player entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            CREATE TABLE `player` (
                id INT AUTO_INCREMENT NOT NULL, 
                first_name VARCHAR(255) NOT NULL, 
                last_name VARCHAR(255) NOT NULL, 
                ranking INT NOT NULL, 
                active TINYINT(1) NOT NULL, 
                PRIMARY KEY(id)
            ) 
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` 
            ENGINE = InnoDB;
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE `player`");
    }
}

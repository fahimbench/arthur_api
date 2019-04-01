<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190331230620 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE niko_niko_planner (id INT AUTO_INCREMENT NOT NULL, fk_id_nikonikogroups_id INT NOT NULL, date_start DATE NOT NULL, date_end DATE NOT NULL, date_ignore JSON DEFAULT NULL COMMENT \'(DC2Type:json_array)\', UNIQUE INDEX UNIQ_B37108D6F503B852 (fk_id_nikonikogroups_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_theme (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niko_niko_groups (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, users JSON NOT NULL COMMENT \'(DC2Type:json_array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_ladder (id INT AUTO_INCREMENT NOT NULL, user VARCHAR(255) NOT NULL, score INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niko_niko_data (id INT AUTO_INCREMENT NOT NULL, fk_id_nikonikoplanner_id INT NOT NULL, date_send DATETIME NOT NULL, result JSON DEFAULT NULL COMMENT \'(DC2Type:json_array)\', UNIQUE INDEX UNIQ_D08A34B6DD02319D (fk_id_nikonikoplanner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE qestion_data (id INT AUTO_INCREMENT NOT NULL, fk_id_theme_id INT NOT NULL, question VARCHAR(255) NOT NULL, answers VARCHAR(255) NOT NULL, result_text VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_E3D8001F602F3426 (fk_id_theme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE akinator_current_games (id INT AUTO_INCREMENT NOT NULL, user VARCHAR(255) NOT NULL, params VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE niko_niko_planner ADD CONSTRAINT FK_B37108D6F503B852 FOREIGN KEY (fk_id_nikonikogroups_id) REFERENCES niko_niko_groups (id)');
        $this->addSql('ALTER TABLE niko_niko_data ADD CONSTRAINT FK_D08A34B6DD02319D FOREIGN KEY (fk_id_nikonikoplanner_id) REFERENCES niko_niko_planner (id)');
        $this->addSql('ALTER TABLE qestion_data ADD CONSTRAINT FK_E3D8001F602F3426 FOREIGN KEY (fk_id_theme_id) REFERENCES question_theme (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE niko_niko_data DROP FOREIGN KEY FK_D08A34B6DD02319D');
        $this->addSql('ALTER TABLE qestion_data DROP FOREIGN KEY FK_E3D8001F602F3426');
        $this->addSql('ALTER TABLE niko_niko_planner DROP FOREIGN KEY FK_B37108D6F503B852');
        $this->addSql('DROP TABLE niko_niko_planner');
        $this->addSql('DROP TABLE question_theme');
        $this->addSql('DROP TABLE niko_niko_groups');
        $this->addSql('DROP TABLE question_ladder');
        $this->addSql('DROP TABLE niko_niko_data');
        $this->addSql('DROP TABLE qestion_data');
        $this->addSql('DROP TABLE akinator_current_games');
    }
}

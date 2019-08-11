<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190811191839 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE question_data (id INT AUTO_INCREMENT NOT NULL, question_theme_id INT NOT NULL, question VARCHAR(255) NOT NULL, answers VARCHAR(255) NOT NULL, result_text VARCHAR(255) DEFAULT NULL, INDEX IDX_F31D1E8C3A0AC48B (question_theme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE akinator_current_games (id INT AUTO_INCREMENT NOT NULL, user VARCHAR(255) NOT NULL, params VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niko_niko_groups (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, users JSON NOT NULL COMMENT \'(DC2Type:json_array)\', date_start DATE NOT NULL, date_end DATE NOT NULL, date_ignore JSON DEFAULT NULL COMMENT \'(DC2Type:json_array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_ladder (id INT AUTO_INCREMENT NOT NULL, user VARCHAR(255) NOT NULL, score INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niko_niko_data (id INT AUTO_INCREMENT NOT NULL, nikonikogroups_id INT NOT NULL, date_send DATETIME NOT NULL, result JSON DEFAULT NULL COMMENT \'(DC2Type:json_array)\', INDEX IDX_D08A34B6A25EE229 (nikonikogroups_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_theme (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE refresh_tokens (id INT AUTO_INCREMENT NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid DATETIME NOT NULL, UNIQUE INDEX UNIQ_9BACE7E1C74F2195 (refresh_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE question_data ADD CONSTRAINT FK_F31D1E8C3A0AC48B FOREIGN KEY (question_theme_id) REFERENCES question_theme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE niko_niko_data ADD CONSTRAINT FK_D08A34B6A25EE229 FOREIGN KEY (nikonikogroups_id) REFERENCES niko_niko_groups (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE niko_niko_data DROP FOREIGN KEY FK_D08A34B6A25EE229');
        $this->addSql('ALTER TABLE question_data DROP FOREIGN KEY FK_F31D1E8C3A0AC48B');
        $this->addSql('DROP TABLE question_data');
        $this->addSql('DROP TABLE akinator_current_games');
        $this->addSql('DROP TABLE niko_niko_groups');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE question_ladder');
        $this->addSql('DROP TABLE niko_niko_data');
        $this->addSql('DROP TABLE question_theme');
        $this->addSql('DROP TABLE refresh_tokens');
    }
}

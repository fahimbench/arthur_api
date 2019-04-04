<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190331231234 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE niko_niko_planner CHANGE date_ignore date_ignore JSON DEFAULT NULL COMMENT \'(DC2Type:json_array)\'');
        $this->addSql('ALTER TABLE niko_niko_data DROP INDEX UNIQ_D08A34B6DD02319D, ADD INDEX IDX_D08A34B6DD02319D (fk_id_nikonikoplanner_id)');
        $this->addSql('ALTER TABLE niko_niko_data CHANGE result result JSON DEFAULT NULL COMMENT \'(DC2Type:json_array)\'');
        $this->addSql('ALTER TABLE qestion_data DROP INDEX UNIQ_E3D8001F602F3426, ADD INDEX IDX_E3D8001F602F3426 (fk_id_theme_id)');
        $this->addSql('ALTER TABLE qestion_data CHANGE result_text result_text VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE akinator_current_games CHANGE params params VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE akinator_current_games CHANGE params params VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE niko_niko_data DROP INDEX IDX_D08A34B6DD02319D, ADD UNIQUE INDEX UNIQ_D08A34B6DD02319D (fk_id_nikonikoplanner_id)');
        $this->addSql('ALTER TABLE niko_niko_data CHANGE result result JSON DEFAULT \'NULL\' COLLATE utf8mb4_bin COMMENT \'(DC2Type:json_array)\'');
        $this->addSql('ALTER TABLE niko_niko_planner CHANGE date_ignore date_ignore JSON DEFAULT \'NULL\' COLLATE utf8mb4_bin COMMENT \'(DC2Type:json_array)\'');
        $this->addSql('ALTER TABLE qestion_data DROP INDEX IDX_E3D8001F602F3426, ADD UNIQUE INDEX UNIQ_E3D8001F602F3426 (fk_id_theme_id)');
        $this->addSql('ALTER TABLE qestion_data CHANGE result_text result_text VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}

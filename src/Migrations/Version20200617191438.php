<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200617191438 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE employment_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE family_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organization (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, name VARCHAR(50) NOT NULL, INDEX IDX_C1EE637C9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE position (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_form (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resume (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, position_id_id INT DEFAULT NULL, status VARBINARY(255) DEFAULT NULL, moderation_status VARBINARY(255) DEFAULT NULL, refuse_reason LONGTEXT DEFAULT NULL, work_experience LONGTEXT DEFAULT NULL, education LONGTEXT DEFAULT NULL, salary INT DEFAULT NULL, personal_quality LONGTEXT DEFAULT NULL, info LONGTEXT DEFAULT NULL, INDEX IDX_60C1D0A09D86650F (user_id_id), INDEX IDX_60C1D0A0F3847A8A (position_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, family_status_id INT DEFAULT NULL, username VARCHAR(50) NOT NULL, password VARCHAR(50) NOT NULL, admin VARBINARY(255) DEFAULT NULL, worker VARBINARY(255) DEFAULT NULL, employer VARBINARY(255) DEFAULT NULL, name VARCHAR(50) DEFAULT NULL, email VARCHAR(50) NOT NULL, birth_date DATE DEFAULT NULL, INDEX IDX_8D93D649A2399AD0 (family_status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vacancy (id INT AUTO_INCREMENT NOT NULL, organization_id_id INT NOT NULL, payment_form_id INT DEFAULT NULL, employment_type_id INT DEFAULT NULL, status VARBINARY(255) DEFAULT NULL, moderation_status VARBINARY(255) DEFAULT NULL, refuse_reason LONGTEXT DEFAULT NULL, work_place LONGTEXT DEFAULT NULL, work_experience LONGTEXT DEFAULT NULL, education LONGTEXT DEFAULT NULL, job_description LONGTEXT DEFAULT NULL, learning_opportunity VARBINARY(255) DEFAULT NULL, info LONGTEXT DEFAULT NULL, INDEX IDX_A9346CBDF1C37890 (organization_id_id), INDEX IDX_A9346CBD46BF9597 (payment_form_id), INDEX IDX_A9346CBD1BCDC34A (employment_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE responses (id INT AUTO_INCREMENT NOT NULL, resume_id_id INT NOT NULL, vacancy_id_id INT NOT NULL, worker_date DATE DEFAULT NULL, worker_status VARBINARY(255) DEFAULT NULL, employer_date DATE DEFAULT NULL, employer_status VARBINARY(255) DEFAULT NULL, INDEX IDX_315F9F94E3B35E3F (resume_id_id), INDEX IDX_315F9F94A60AE135 (vacancy_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE organization ADD CONSTRAINT FK_C1EE637C9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE responses ADD CONSTRAINT FK_315F9F94E3B35E3F FOREIGN KEY (resume_id_id) REFERENCES resume (id)');
        $this->addSql('ALTER TABLE responses ADD CONSTRAINT FK_315F9F94A60AE135 FOREIGN KEY (vacancy_id_id) REFERENCES vacancy (id)');
        $this->addSql('ALTER TABLE resume ADD CONSTRAINT FK_60C1D0A09D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE resume ADD CONSTRAINT FK_60C1D0A0F3847A8A FOREIGN KEY (position_id_id) REFERENCES position (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A2399AD0 FOREIGN KEY (family_status_id) REFERENCES family_status (id)');
        $this->addSql('ALTER TABLE vacancy ADD CONSTRAINT FK_A9346CBDF1C37890 FOREIGN KEY (organization_id_id) REFERENCES organization (id)');
        $this->addSql('ALTER TABLE vacancy ADD CONSTRAINT FK_A9346CBD46BF9597 FOREIGN KEY (payment_form_id) REFERENCES payment_form (id)');
        $this->addSql('ALTER TABLE vacancy ADD CONSTRAINT FK_A9346CBD1BCDC34A FOREIGN KEY (employment_type_id) REFERENCES employment_type (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE vacancy DROP FOREIGN KEY FK_A9346CBD1BCDC34A');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649A2399AD0');
        $this->addSql('ALTER TABLE vacancy DROP FOREIGN KEY FK_A9346CBDF1C37890');
        $this->addSql('ALTER TABLE resume DROP FOREIGN KEY FK_60C1D0A0F3847A8A');
        $this->addSql('ALTER TABLE vacancy DROP FOREIGN KEY FK_A9346CBD46BF9597');
        $this->addSql('ALTER TABLE responses DROP FOREIGN KEY FK_315F9F94E3B35E3F');
        $this->addSql('ALTER TABLE organization DROP FOREIGN KEY FK_C1EE637C9D86650F');
        $this->addSql('ALTER TABLE resume DROP FOREIGN KEY FK_60C1D0A09D86650F');
        $this->addSql('ALTER TABLE responses DROP FOREIGN KEY FK_315F9F94A60AE135');
        $this->addSql('DROP TABLE employment_type');
        $this->addSql('DROP TABLE family_status');
        $this->addSql('DROP TABLE organization');
        $this->addSql('DROP TABLE responses');
        $this->addSql('DROP TABLE position');
        $this->addSql('DROP TABLE payment_form');
        $this->addSql('DROP TABLE resume');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vacancy');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241231132501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, location LONGTEXT DEFAULT NULL, description LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_4FBF094FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE developer (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, birthday DATE DEFAULT NULL, gender VARCHAR(255) DEFAULT NULL, experiences INT NOT NULL, salary INT NOT NULL, biography LONGTEXT DEFAULT NULL, location LONGTEXT DEFAULT NULL, avatar LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_65FB8B9AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE developer_developer (developer_source INT NOT NULL, developer_target INT NOT NULL, INDEX IDX_6161C76BAA6A33E4 (developer_source), INDEX IDX_6161C76BB38F636B (developer_target), PRIMARY KEY(developer_source, developer_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poste (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, location LONGTEXT NOT NULL, experiences INT NOT NULL, min_salary INT DEFAULT NULL, max_salary INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7C890FAB979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_developer (skill_id INT NOT NULL, developer_id INT NOT NULL, INDEX IDX_360AB0C75585C142 (skill_id), INDEX IDX_360AB0C764DD9267 (developer_id), PRIMARY KEY(skill_id, developer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_poste (skill_id INT NOT NULL, poste_id INT NOT NULL, INDEX IDX_59A19C975585C142 (skill_id), INDEX IDX_59A19C97A0905086 (poste_id), PRIMARY KEY(skill_id, poste_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE developer ADD CONSTRAINT FK_65FB8B9AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE developer_developer ADD CONSTRAINT FK_6161C76BAA6A33E4 FOREIGN KEY (developer_source) REFERENCES developer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE developer_developer ADD CONSTRAINT FK_6161C76BB38F636B FOREIGN KEY (developer_target) REFERENCES developer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE poste ADD CONSTRAINT FK_7C890FAB979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE skill_developer ADD CONSTRAINT FK_360AB0C75585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_developer ADD CONSTRAINT FK_360AB0C764DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_poste ADD CONSTRAINT FK_59A19C975585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_poste ADD CONSTRAINT FK_59A19C97A0905086 FOREIGN KEY (poste_id) REFERENCES poste (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094FA76ED395');
        $this->addSql('ALTER TABLE developer DROP FOREIGN KEY FK_65FB8B9AA76ED395');
        $this->addSql('ALTER TABLE developer_developer DROP FOREIGN KEY FK_6161C76BAA6A33E4');
        $this->addSql('ALTER TABLE developer_developer DROP FOREIGN KEY FK_6161C76BB38F636B');
        $this->addSql('ALTER TABLE poste DROP FOREIGN KEY FK_7C890FAB979B1AD6');
        $this->addSql('ALTER TABLE skill_developer DROP FOREIGN KEY FK_360AB0C75585C142');
        $this->addSql('ALTER TABLE skill_developer DROP FOREIGN KEY FK_360AB0C764DD9267');
        $this->addSql('ALTER TABLE skill_poste DROP FOREIGN KEY FK_59A19C975585C142');
        $this->addSql('ALTER TABLE skill_poste DROP FOREIGN KEY FK_59A19C97A0905086');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE developer');
        $this->addSql('DROP TABLE developer_developer');
        $this->addSql('DROP TABLE poste');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE skill_developer');
        $this->addSql('DROP TABLE skill_poste');
        $this->addSql('ALTER TABLE user DROP created_at, DROP updated_at');
    }
}

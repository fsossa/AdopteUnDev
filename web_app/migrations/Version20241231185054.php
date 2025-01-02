<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241231185054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company_fav_developer (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, developer_id INT NOT NULL, INDEX IDX_B3CD9B5A979B1AD6 (company_id), INDEX IDX_B3CD9B5A64DD9267 (developer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company_visite_developer (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, developer_id INT NOT NULL, INDEX IDX_A8B1BBB7979B1AD6 (company_id), INDEX IDX_A8B1BBB764DD9267 (developer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE developer_fav_poste (id INT AUTO_INCREMENT NOT NULL, developer_id INT NOT NULL, poste_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_1960A7D164DD9267 (developer_id), INDEX IDX_1960A7D1A0905086 (poste_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE developer_visite_poste (id INT AUTO_INCREMENT NOT NULL, developer_id INT NOT NULL, poste_id INT NOT NULL, INDEX IDX_38729EAE64DD9267 (developer_id), INDEX IDX_38729EAEA0905086 (poste_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company_fav_developer ADD CONSTRAINT FK_B3CD9B5A979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE company_fav_developer ADD CONSTRAINT FK_B3CD9B5A64DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id)');
        $this->addSql('ALTER TABLE company_visite_developer ADD CONSTRAINT FK_A8B1BBB7979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE company_visite_developer ADD CONSTRAINT FK_A8B1BBB764DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id)');
        $this->addSql('ALTER TABLE developer_fav_poste ADD CONSTRAINT FK_1960A7D164DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id)');
        $this->addSql('ALTER TABLE developer_fav_poste ADD CONSTRAINT FK_1960A7D1A0905086 FOREIGN KEY (poste_id) REFERENCES poste (id)');
        $this->addSql('ALTER TABLE developer_visite_poste ADD CONSTRAINT FK_38729EAE64DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id)');
        $this->addSql('ALTER TABLE developer_visite_poste ADD CONSTRAINT FK_38729EAEA0905086 FOREIGN KEY (poste_id) REFERENCES poste (id)');
        $pass = password_hash('123456', PASSWORD_BCRYPT);
        $this->addSql("INSERT INTO user VALUES (1, 'fulbsossa17@gmail.com', json)");
        $this->addSql("
            INSERT INTO user (id, email, roles, password)
            VALUES (
                1,
                'fulbsossa17@gmail.com',
                '[\"ROLE_DEV\"]',
                $pass,
            )
        ");

        // $this->addSql("
        //     INSERT INTO user (email, roles, password)
        //     VALUES (
        //         'monelcocou@gmail.com',
        //         '[\"ROLE_DEV\"]',
        //         $pass,
        //     )
        // ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company_fav_developer DROP FOREIGN KEY FK_B3CD9B5A979B1AD6');
        $this->addSql('ALTER TABLE company_fav_developer DROP FOREIGN KEY FK_B3CD9B5A64DD9267');
        $this->addSql('ALTER TABLE company_visite_developer DROP FOREIGN KEY FK_A8B1BBB7979B1AD6');
        $this->addSql('ALTER TABLE company_visite_developer DROP FOREIGN KEY FK_A8B1BBB764DD9267');
        $this->addSql('ALTER TABLE developer_fav_poste DROP FOREIGN KEY FK_1960A7D164DD9267');
        $this->addSql('ALTER TABLE developer_fav_poste DROP FOREIGN KEY FK_1960A7D1A0905086');
        $this->addSql('ALTER TABLE developer_visite_poste DROP FOREIGN KEY FK_38729EAE64DD9267');
        $this->addSql('ALTER TABLE developer_visite_poste DROP FOREIGN KEY FK_38729EAEA0905086');
        $this->addSql('DROP TABLE company_fav_developer');
        $this->addSql('DROP TABLE company_visite_developer');
        $this->addSql('DROP TABLE developer_fav_poste');
        $this->addSql('DROP TABLE developer_visite_poste');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\ORM\EntityManager;

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
        
        // $entityM = new EntityManager();
        // UserRepository::createDefaultUser($entityM, true);
        // $userR = new UserRepository();
        $secret = password_hash('123456', PASSWORD_BCRYPT);
        $this->addSql("INSERT INTO user VALUES (1, 'developer@test.xyz', '[\"ROLE_USER\", \"ROLE_DEV\"]', '$secret', 1, NOW(), NOW())");

        $this->addSql("INSERT INTO developer (id, user_id, firstname, lastname, gender, experiences, salary)
            VALUES (1, 1, 'Ange', 'GOHI', 'F', 2, 2000)");

        $this->addSql("INSERT INTO user VALUES (2, 'company@test.xyz', '[\"ROLE_USER\", \"ROLE_COMPANY\"]', '$secret', 1, NOW(), NOW())");
        
        $this->addSql("INSERT INTO company (id, user_id, name)
            VALUES (1, 2, 'MAFE')");

        // Liste des compétences avec descriptions
        $skills = [
            ['name' => 'Java', 'description' => 'Langage de programmation orienté objet, utilisé pour le développement web, mobile et d’applications d’entreprise.'],
            ['name' => 'SQL', 'description' => 'Langage standard pour interagir avec les bases de données relationnelles.'],
            ['name' => 'HTML', 'description' => 'Langage de balisage utilisé pour structurer le contenu des pages web.'],
            ['name' => 'CSS', 'description' => 'Langage de style utilisé pour décrire la présentation des pages web.'],
            ['name' => 'Symfony', 'description' => 'Framework PHP pour développer des applications web robustes.'],
            ['name' => 'React', 'description' => 'Bibliothèque JavaScript pour construire des interfaces utilisateur dynamiques.'],
            ['name' => 'Angular', 'description' => 'Framework front-end développé par Google pour créer des applications web modernes.'],
            ['name' => 'Vue.js', 'description' => 'Framework JavaScript progressif pour construire des interfaces utilisateur.'],
            ['name' => 'Python', 'description' => 'Langage de programmation polyvalent apprécié pour sa simplicité et sa lisibilité.'],
            ['name' => 'Django', 'description' => 'Framework web Python destiné au développement rapide et sécurisé.'],
            ['name' => 'Flask', 'description' => 'Micro-framework Python léger pour créer des applications web.'],
            ['name' => 'PHP', 'description' => 'Langage de programmation côté serveur pour développer des applications web.'],
            ['name' => 'Laravel', 'description' => 'Framework PHP moderne et élégant pour le développement web.'],
            ['name' => 'C#', 'description' => 'Langage de programmation Microsoft pour des applications robustes et performantes.'],
            ['name' => 'ASP.NET', 'description' => 'Framework pour construire des applications web dynamiques avec .NET.'],
            ['name' => 'Ruby on Rails', 'description' => 'Framework web Ruby pour des applications rapides et agiles.'],
            ['name' => 'Node.js', 'description' => 'Environnement d’exécution JavaScript côté serveur.'],
            ['name' => 'Express.js', 'description' => 'Framework web minimaliste pour Node.js.'],
            ['name' => 'Go', 'description' => 'Langage de programmation performant conçu par Google.'],
            ['name' => 'Rust', 'description' => 'Langage de programmation performant et sécurisé.'],
            ['name' => 'Kotlin', 'description' => 'Langage de programmation moderne et concis pour les applications Android.'],
            ['name' => 'Swift', 'description' => 'Langage de programmation pour le développement des applications Apple.'],
            ['name' => 'TypeScript', 'description' => 'Superset de JavaScript qui ajoute des types statiques.'],
            ['name' => 'JavaScript', 'description' => 'Langage de programmation pour rendre les sites web interactifs.'],
            ['name' => 'Perl', 'description' => 'Langage polyvalent pour le traitement de texte et l’automatisation.'],
            ['name' => 'C++', 'description' => 'Langage de programmation orienté objet pour des performances élevées.'],
            ['name' => 'C', 'description' => 'Langage de programmation bas niveau pour des systèmes et applications robustes.'],
            ['name' => 'Bash', 'description' => 'Langage de script pour l’automatisation sous Unix/Linux.'],
            ['name' => 'Docker', 'description' => 'Outil de conteneurisation pour le déploiement d’applications.'],
            ['name' => 'Kubernetes', 'description' => 'Système d’orchestration de conteneurs à grande échelle.'],
            ['name' => 'AWS', 'description' => 'Plateforme cloud complète et évolutive d’Amazon.'],
            ['name' => 'Azure', 'description' => 'Plateforme cloud de Microsoft pour les services et les solutions.'],
            ['name' => 'Google Cloud', 'description' => 'Suite de services cloud proposée par Google.'],
            ['name' => 'MySQL', 'description' => 'Système de gestion de base de données relationnelle open source.'],
            ['name' => 'PostgreSQL', 'description' => 'SGBD avancé et open source.'],
            ['name' => 'MongoDB', 'description' => 'Base de données NoSQL orientée documents.'],
            ['name' => 'Redis', 'description' => 'Base de données NoSQL rapide en mémoire.'],
            ['name' => 'GraphQL', 'description' => 'Langage de requête pour les APIs flexible et performant.'],
            ['name' => 'REST APIs', 'description' => 'Style d’architecture pour la conception d’API web.'],
            ['name' => 'Jenkins', 'description' => 'Outil open source pour l’intégration et le déploiement continus.'],
            ['name' => 'Git', 'description' => 'Système de contrôle de version distribué.']
        ];

        // Insertion des compétences
        $now = (new \DateTimeImmutable())->format('Y-m-d H:i:s');
        foreach ($skills as $skill) {
            $this->addSql(
                'INSERT INTO skill (name, description, created_at, updated_at) VALUES (:name, :description, :created_at, :updated_at)',
                [
                    'name' => $skill['name'],
                    'description' => $skill['description'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
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

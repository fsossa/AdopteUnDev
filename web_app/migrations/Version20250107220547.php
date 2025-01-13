<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250107220547 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout de 40 nouvelles compétences avec descriptions dans la table Skill';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, location LONGTEXT DEFAULT NULL, description LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_4FBF094FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company_fav_developer (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, developer_id INT NOT NULL, INDEX IDX_B3CD9B5A979B1AD6 (company_id), INDEX IDX_B3CD9B5A64DD9267 (developer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company_visite_developer (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, developer_id INT NOT NULL, INDEX IDX_A8B1BBB7979B1AD6 (company_id), INDEX IDX_A8B1BBB764DD9267 (developer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE developer (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, birthday DATE DEFAULT NULL, gender VARCHAR(255) DEFAULT NULL, experiences INT NOT NULL, salary INT NOT NULL, biography LONGTEXT DEFAULT NULL, location LONGTEXT DEFAULT NULL, avatar LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_65FB8B9AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE developer_developer (developer_source INT NOT NULL, developer_target INT NOT NULL, INDEX IDX_6161C76BAA6A33E4 (developer_source), INDEX IDX_6161C76BB38F636B (developer_target), PRIMARY KEY(developer_source, developer_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE developer_fav_poste (id INT AUTO_INCREMENT NOT NULL, developer_id INT NOT NULL, poste_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_1960A7D164DD9267 (developer_id), INDEX IDX_1960A7D1A0905086 (poste_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE developer_visite_poste (id INT AUTO_INCREMENT NOT NULL, developer_id INT NOT NULL, poste_id INT NOT NULL, INDEX IDX_38729EAE64DD9267 (developer_id), INDEX IDX_38729EAEA0905086 (poste_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poste (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, location LONGTEXT NOT NULL, experiences INT NOT NULL, min_salary INT DEFAULT NULL, max_salary INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7C890FAB979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_developer (skill_id INT NOT NULL, developer_id INT NOT NULL, INDEX IDX_360AB0C75585C142 (skill_id), INDEX IDX_360AB0C764DD9267 (developer_id), PRIMARY KEY(skill_id, developer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_poste (skill_id INT NOT NULL, poste_id INT NOT NULL, INDEX IDX_59A19C975585C142 (skill_id), INDEX IDX_59A19C97A0905086 (poste_id), PRIMARY KEY(skill_id, poste_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE company_fav_developer ADD CONSTRAINT FK_B3CD9B5A979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE company_fav_developer ADD CONSTRAINT FK_B3CD9B5A64DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id)');
        $this->addSql('ALTER TABLE company_visite_developer ADD CONSTRAINT FK_A8B1BBB7979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE company_visite_developer ADD CONSTRAINT FK_A8B1BBB764DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id)');
        $this->addSql('ALTER TABLE developer ADD CONSTRAINT FK_65FB8B9AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE developer_developer ADD CONSTRAINT FK_6161C76BAA6A33E4 FOREIGN KEY (developer_source) REFERENCES developer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE developer_developer ADD CONSTRAINT FK_6161C76BB38F636B FOREIGN KEY (developer_target) REFERENCES developer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE developer_fav_poste ADD CONSTRAINT FK_1960A7D164DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id)');
        $this->addSql('ALTER TABLE developer_fav_poste ADD CONSTRAINT FK_1960A7D1A0905086 FOREIGN KEY (poste_id) REFERENCES poste (id)');
        $this->addSql('ALTER TABLE developer_visite_poste ADD CONSTRAINT FK_38729EAE64DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id)');
        $this->addSql('ALTER TABLE developer_visite_poste ADD CONSTRAINT FK_38729EAEA0905086 FOREIGN KEY (poste_id) REFERENCES poste (id)');
        $this->addSql('ALTER TABLE poste ADD CONSTRAINT FK_7C890FAB979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE skill_developer ADD CONSTRAINT FK_360AB0C75585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_developer ADD CONSTRAINT FK_360AB0C764DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_poste ADD CONSTRAINT FK_59A19C975585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_poste ADD CONSTRAINT FK_59A19C97A0905086 FOREIGN KEY (poste_id) REFERENCES poste (id) ON DELETE CASCADE');

        // Default data
        $secret = password_hash('123456', PASSWORD_BCRYPT);
        $this->addSql("INSERT INTO user VALUES (1, 'developer@test.xyz', '[\"ROLE_USER\", \"ROLE_DEV\"]', '$secret', 1, NOW(), NOW())");

        $this->addSql("INSERT INTO developer (id, user_id, firstname, lastname, gender, experiences, salary)
            VALUES (1, 1, 'Ange', 'GOHI', 'F', 2, 2000)");

        $this->addSql("INSERT INTO user VALUES (2, 'company@test.xyz', '[\"ROLE_USER\", \"ROLE_COMPANY\"]', '$secret', 1, NOW(), NOW())");

        $this->addSql("INSERT INTO company (id, user_id, name)
            VALUES (1, 2, 'MAFE')");



        $this->GenerationjeuDeDonneesSkills();
        $this->GenerationjeuDeDonneesFicheDePoste();
        $this->GenerationjeuDeDonneesVisiteDePoste();
        $this->GenerationjeuDeDonneesVisiteDeDeveloper();
    }



    private function GenerationjeuDeDonneesSkills(): void
    {
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

    private function GenerationjeuDeDonneesFicheDePoste(): void
    {
        // Liste des 15 postes avec leurs informations
        $postes = [
            [
                'title' => 'Développeur Symfony',
                'description' => 'Développeur backend avec expertise en Symfony pour construire des applications web robustes et scalables.',
                'location' => 'Paris, France',
                'experiences' => 3,
                'min_salary' => 35000,
                'max_salary' => 45000,
                'company' => 1, // ID de la société à associer
            ],
            [
                'title' => 'Développeur Full Stack React',
                'description' => 'Développeur Full Stack pour la création d’applications interactives avec React.js, Next.js et Node.js.',
                'location' => 'Lyon, France',
                'experiences' => 5,
                'min_salary' => 40000,
                'max_salary' => 60000,
                'company' => 1, // ID de la société à associer
            ],
            [
                'title' => 'Chef de Projet Technique',
                'description' => 'Responsable du pilotage des projets techniques, gestion de l’équipe et suivi des livrables.',
                'location' => 'Remote',
                'experiences' => 7,
                'min_salary' => 55000,
                'max_salary' => 75000,
                'company' => 1, // ID de la société à associer
            ],
            [
                'title' => 'Développeur Backend Node.js',
                'description' => 'Développeur backend pour créer des applications performantes et évolutives avec Node.js et Express.',
                'location' => 'Marseille, France',
                'experiences' => 4,
                'min_salary' => 38000,
                'max_salary' => 52000,
                'company' => 1, // ID de la société à associer
            ],
            [
                'title' => 'Ingénieur DevOps',
                'description' => 'Responsable de l’automatisation des processus de développement et de déploiement avec Docker et Kubernetes.',
                'location' => 'Bordeaux, France',
                'experiences' => 6,
                'min_salary' => 50000,
                'max_salary' => 70000,
                'company' => 1, // ID de la société à associer
            ],
            [
                'title' => 'Développeur Python Django',
                'description' => 'Développeur Python pour créer des applications web avec le framework Django, API REST et base de données PostgreSQL.',
                'location' => 'Toulouse, France',
                'experiences' => 3,
                'min_salary' => 35000,
                'max_salary' => 48000,
                'company' => 1, // ID de la société à associer
            ],
            [
                'title' => 'Développeur Mobile Android',
                'description' => 'Développeur Android pour concevoir des applications mobiles performantes avec Kotlin.',
                'location' => 'Paris, France',
                'experiences' => 2,
                'min_salary' => 34000,
                'max_salary' => 45000,
                'company' => 1, // ID de la société à associer
            ],
            [
                'title' => 'Développeur Frontend Vue.js',
                'description' => 'Développeur frontend pour créer des interfaces utilisateur interactives et réactives avec Vue.js.',
                'location' => 'Lyon, France',
                'experiences' => 4,
                'min_salary' => 40000,
                'max_salary' => 55000,
                'company' => 1, // ID de la société à associer
            ],
            [
                'title' => 'Responsable Sécurité Informatique',
                'description' => 'Garantir la sécurité des systèmes d’information et la gestion des incidents de sécurité.',
                'location' => 'Remote',
                'experiences' => 8,
                'min_salary' => 60000,
                'max_salary' => 90000,
                'company' => 1, // ID de la société à associer
            ],
            [
                'title' => 'Développeur PHP Laravel',
                'description' => 'Développeur backend PHP avec une forte expertise dans le framework Laravel pour des applications web robustes.',
                'location' => 'Paris, France',
                'experiences' => 3,
                'min_salary' => 35000,
                'max_salary' => 48000,
                'company' => 1, // ID de la société à associer
            ],
            [
                'title' => 'Développeur Full Stack Java',
                'description' => 'Développeur Full Stack pour la création d’applications d’entreprise avec Java et Spring.',
                'location' => 'Marseille, France',
                'experiences' => 5,
                'min_salary' => 40000,
                'max_salary' => 60000,
                'company' => 1, // ID de la société à associer
            ],
            [
                'title' => 'Data Scientist Python',
                'description' => 'Data Scientist pour analyser les données massives et développer des modèles de machine learning avec Python.',
                'location' => 'Lille, France',
                'experiences' => 4,
                'min_salary' => 45000,
                'max_salary' => 65000,
                'company' => 1, // ID de la société à associer
            ],
            [
                'title' => 'Développeur C# ASP.NET',
                'description' => 'Développeur backend pour créer des applications web dynamiques avec ASP.NET et C#.',
                'location' => 'Bordeaux, France',
                'experiences' => 3,
                'min_salary' => 38000,
                'max_salary' => 52000,
                'company' => 1, // ID de la société à associer
            ],
            [
                'title' => 'Responsable Infrastructure IT',
                'description' => 'Gérer l’infrastructure IT de l’entreprise, superviser les serveurs, les réseaux et assurer la disponibilité des services.',
                'location' => 'Paris, France',
                'experiences' => 6,
                'min_salary' => 55000,
                'max_salary' => 75000,
                'company' => 1, // ID de la société à associer
            ]
        ];

        // Insertion des postes dans la base de données
        $now = (new \DateTimeImmutable())->format('Y-m-d H:i:s');
        foreach ($postes as $poste) {
            $this->addSql(
                'INSERT INTO poste (title, description, location, experiences, min_salary, max_salary, company_id, created_at, updated_at) 
        VALUES (:title, :description, :location, :experiences, :min_salary, :max_salary, :company_id, :created_at, :updated_at)',
                [
                    'title' => $poste['title'],
                    'description' => $poste['description'],
                    'location' => $poste['location'],
                    'experiences' => $poste['experiences'],
                    'min_salary' => $poste['min_salary'],
                    'max_salary' => $poste['max_salary'],
                    'company_id' => $poste['company'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }

    private function GenerationjeuDeDonneesVisiteDePoste(): void{
        $this->addSql("INSERT INTO developer_visite_poste (id, developer_id, poste_id)
            VALUES (1, 1, 1)");
        $this->addSql("INSERT INTO developer_visite_poste (id, developer_id, poste_id)
            VALUES (2, 1, 5)");
    }

    private function GenerationjeuDeDonneesVisiteDeDeveloper(): void{
        $this->addSql("INSERT INTO company_visite_developer (id, developer_id, company_id)
            VALUES (1, 1, 1)");
        // $this->addSql("INSERT INTO company_visite_developer (id, developer_id, company_id)
        //     VALUES (2, 1, 5)");
    }


    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094FA76ED395');
        $this->addSql('ALTER TABLE company_fav_developer DROP FOREIGN KEY FK_B3CD9B5A979B1AD6');
        $this->addSql('ALTER TABLE company_fav_developer DROP FOREIGN KEY FK_B3CD9B5A64DD9267');
        $this->addSql('ALTER TABLE company_visite_developer DROP FOREIGN KEY FK_A8B1BBB7979B1AD6');
        $this->addSql('ALTER TABLE company_visite_developer DROP FOREIGN KEY FK_A8B1BBB764DD9267');
        $this->addSql('ALTER TABLE developer DROP FOREIGN KEY FK_65FB8B9AA76ED395');
        $this->addSql('ALTER TABLE developer_developer DROP FOREIGN KEY FK_6161C76BAA6A33E4');
        $this->addSql('ALTER TABLE developer_developer DROP FOREIGN KEY FK_6161C76BB38F636B');
        $this->addSql('ALTER TABLE developer_fav_poste DROP FOREIGN KEY FK_1960A7D164DD9267');
        $this->addSql('ALTER TABLE developer_fav_poste DROP FOREIGN KEY FK_1960A7D1A0905086');
        $this->addSql('ALTER TABLE developer_visite_poste DROP FOREIGN KEY FK_38729EAE64DD9267');
        $this->addSql('ALTER TABLE developer_visite_poste DROP FOREIGN KEY FK_38729EAEA0905086');
        $this->addSql('ALTER TABLE poste DROP FOREIGN KEY FK_7C890FAB979B1AD6');
        $this->addSql('ALTER TABLE skill_developer DROP FOREIGN KEY FK_360AB0C75585C142');
        $this->addSql('ALTER TABLE skill_developer DROP FOREIGN KEY FK_360AB0C764DD9267');
        $this->addSql('ALTER TABLE skill_poste DROP FOREIGN KEY FK_59A19C975585C142');
        $this->addSql('ALTER TABLE skill_poste DROP FOREIGN KEY FK_59A19C97A0905086');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE company_fav_developer');
        $this->addSql('DROP TABLE company_visite_developer');
        $this->addSql('DROP TABLE developer');
        $this->addSql('DROP TABLE developer_developer');
        $this->addSql('DROP TABLE developer_fav_poste');
        $this->addSql('DROP TABLE developer_visite_poste');
        $this->addSql('DROP TABLE poste');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE skill_developer');
        $this->addSql('DROP TABLE skill_poste');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

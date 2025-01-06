<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250106000000_AddSkills extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout de 40 nouvelles compétences avec descriptions dans la table Skill';
    }

    public function up(Schema $schema): void
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

    public function down(Schema $schema): void
    {
        // Suppression des compétences
        $skills = [
            'Java', 'SQL', 'HTML', 'CSS', 'Symfony', 'React', 'Angular', 'Vue.js',
            'Python', 'Django', 'Flask', 'PHP', 'Laravel', 'C#', 'ASP.NET', 'Ruby on Rails',
            'Node.js', 'Express.js', 'Go', 'Rust', 'Kotlin', 'Swift', 'TypeScript', 'JavaScript',
            'Perl', 'C++', 'C', 'Bash', 'Docker', 'Kubernetes', 'AWS', 'Azure', 'Google Cloud',
            'MySQL', 'PostgreSQL', 'MongoDB', 'Redis', 'GraphQL', 'REST APIs', 'Jenkins', 'Git'
        ];

        foreach ($skills as $skill) {
            $this->addSql(
                'DELETE FROM skill WHERE name = :name',
                ['name' => $skill]
            );
        }
    }
}

# AdopteUnDev

Bienvenue sur le projet **AdopteUnDev** ! Ce projet vise à connecter les développeurs et les entreprises en utilisant des fonctionnalités de matching similaires à celles des sites de rencontres.

## Equipe: 
### I. Fulbert SOSSA
### II. Monel GAFFAN
### III. Marlène GOHI
### IV. Rokia COULIBALY

---

## Installation avec Docker

### 1. Prérequis
- Docker
- Docker Compose

### 2. Étapes d'installation

1. **Clonez le projet :**  
   Clonez le dépôt sur votre machine locale et accédez au dossier.  
   ```bash
   git clone https://github.com/fsossa/AdopteUnDev.git
   cd AdopteUnDev

    Configurez les variables d'environnement :
    Créez un fichier .env.local et configurez la connexion à la base de données :
    DATABASE_URL=postgresql://username:password@db:5432/adopteundev

Lancez les conteneurs avec Docker Compose :
Cela démarrera les services nécessaires à l'application.

    docker-compose up -d

Installez les dépendances PHP :
Exécutez Composer dans le conteneur pour installer les bibliothèques nécessaires.

    docker-compose exec app composer install

Appliquez les migrations :
Configurez la base de données en appliquant les migrations.

    docker-compose exec app php bin/console doctrine:migrations:migrate

Accédez à l'application :
    Ouvrez votre navigateur et rendez-vous sur http://localhost:8000.

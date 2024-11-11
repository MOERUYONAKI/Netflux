# Netflux

Netflux est une application de type catalogue de films, inspirée de la plateforme Netflix. Développée en Symfony, elle permet aux utilisateurs de parcourir et de découvrir des films avec des informations telles que le titre, la date de sortie, le réalisateur, le genre, la durée, et une affiche ou bande-annonce. Ce projet est conçu pour aider les développeurs à explorer les fonctionnalités de Symfony, comme les formulaires, l’upload de fichiers, et la gestion de base de données.

## Fonctionnalités

- **Affichage du catalogue de films** : Visualisez tous les films disponibles avec des détails spécifiques.
- **Ajout de films** : Ajoutez des films avec des informations complètes, y compris une affiche (image) et une vidéo.
- **Stockage en base de données** : Seuls les chemins des fichiers sont stockés en base de données, ce qui optimise le stockage.

## Prérequis

Avant de commencer, assurez-vous d'avoir installé les outils suivants :

- PHP >= 8.0
- Composer
- Symfony CLI
- MariaDB ou un autre SGBD compatible

## Installation

1. **Clonez le dépôt** :
   ```
   git clone https://github.com/votre-nom-utilisateur/netflux.git  
   cd netflux  
   ```

2. **Installez les dépendances** :
   ```
   composer install  
   ```

3. **Configurez la base de données** :
   ```
   DATABASE_URL="mysql://user:password@127.0.0.1:3306/netflux"  
   ```

4. **Créez la base de données et exécutez les migrations** :
   ```
   php bin/console doctrine:database:create  
   php bin/console doctrine:migrations:migrate  
   ```

5. **Installez les assets** :
   ```
   npm install  
   npm run build  
   ```

6. **Démarrez le serveur** :
   ```
   symfony serve
   ```


# Atelier Symfony : Rédaction du README

Ce projet a pour objectif de créer une application Symfony pour la gestion d'un annuaire. Ce guide détaille les étapes nécessaires pour déployer et configurer le projet.

# Installation des dépendances PHP
composer install

# Installation des dépendances Node.js
npm install # ou yarn install

# Installation des assets publics
symfony console assets:install

# Nettoyage et régénération du cache
symfony console cache:clear



## Configuration de la base de données
Utilisation de MySQL
Modifiez le fichier .env.local pour définir les informations de connexion à votre base de données MySQL :

env

DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/gestion-conges"
Vérifiez si MySQL est installé sur votre machine (Windows) :

bash
Copier le code
mysql --version
Créez la base de données avec la commande suivante :

bash
Copier le code
symfony console doctrine:database:create
Vérifiez que la base de données est bien créée et qu'il n'y a pas d'erreurs.

## Lancer les fixtures : 
Une fois vos fixtures prêtes, vous pouvez les charger dans la base de données avec la commande suivante :

bash
Copier le code
php bin/console doctrine:fixtures:load

## Vérification

# Créer la base de données si nécessaire
php bin/console doctrine:database:create

# Générer les migrations à partir des entités
php bin/console doctrine:migrations:generate

# Appliquer les migrations pour mettre à jour la base de données
php bin/console doctrine:migrations:migrate

# Valider le schéma de la base de données
php bin/console doctrine:schema:validate

# Si vous voulez repartir sur une base propre, supprimez-la et recréez-la

# Supprimer la base de données (forcer la suppression)
php bin/console doctrine:database:drop --force

# Recréer la base de données
php bin/console doctrine:database:create

# Valider à nouveau le schéma de la base de données
php bin/console doctrine:schema:validate


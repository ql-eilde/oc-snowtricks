Snowtricks
==========

This is the public repository of my 6th project on OpenClassrooms. The goal of this project is to create a community platform around snowtricks. This platform use Symfony3 and Doctrine2.

# Installation
## 1. Récupérer le code

1. Via Git, en clonant ce dépôt ;

## 2. Télécharger les vendors et définir les paramètres d'application
Avec Composer bien évidemment :

    php composer.phar install

On vous demande à la fin de l'installation de définir les paramètres de l'application (connexion à la base de données), complétez les informations demandées et validez.

## 3. Créez la base de données
Si la base de données que vous avez renseignée dans l'étape 2 n'existe pas déjà, créez-la :

    php bin/console doctrine:database:create

Puis créez les tables correspondantes au schéma Doctrine :

    php bin/console doctrine:schema:update --force

Enfin, ajoutez les fixtures :

    php bin/console doctrine:fixtures:load

## 4. Publiez les assets
Publiez les assets dans le répertoire web :

    php bin/console assets:install web
    
## 5. Créez un user et lancez la commande de création de tricks
Il va falloir créer un user admin, pour cela lancez la commande suivante :

    php bin/console fos:user:create

Indiquez comme username 'admin'. Mettez ce que vous voulez en email et mot de passe.

Il faut ensuite lancer la commande qui va lire le fichier `src/ST/PlatformBundle/Command/tricks.yml`, qui est un fichier yaml regroupant 10 tricks, qui va parser ce document et persisté les tricks en base de données. Pour cela lancez cette commande :

    php bin/console app:create-tricks

*Attention, il est important de ne surtout pas modifier le fichier tricks.yml*   

## Et profitez !

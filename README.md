GARAGE AUTOMOBILE

V. Parrot

Pour tester l'application: (d'abord en local, pour la version en ligne voir plus bas).

-------------------------------------------------------------------------------------------------------------------------------------------------------

sur votre machine installez, depuis les sites officiels: 
- COMPOSER:
  https://getcomposer.org/Composer-Setup.exe
- NODE.JS:
  https://nodejs.org/dist/v20.11.1/node-v20.11.1-x64.msi
- WAMP SERVER:
  https://www.wampserver.com/en/download-wampserver-64bits/#wampserver-64-bits-php-5-6-25-php-7
  

Cloner le repository:

sur votre machine locale, créez un dossier à l'endroit de votre choix et placez-vous à la racine de ce dossier et clonez le repository GitHub avec la commande suivante:

--> git clone https://github.com/BrunoStudi/Garage_Automobile.git

Apres avoir cloner le projet du github, lancer les commandes suivantes sur le terminal en etant à la racine du dossier projet:

-	composer install
-	npm install
-	npm install vue bootstrap-vue bootstrap

Ensuite lancez Wamp server, attendez que tout les services soient prêt et allez dans la barre des taches, zone des notifications et cliquez avec le bouton gauche sur l'icone ressemblant à un W en vert puis PHPmyAdmin et PHPmyAdmin.

Connectez vous avec l'identifiant "root" et un mot de pass vide et choix du serveur "MySQL".
Créez une nouvelle base de donnée en vous rendant dans SQL au niveau de l'onglet superieur,
entrez la commende suivante: 

CREATE DATABASE garageautomobile; puis cliquez sur le bouton "executer"

Fichier SQL de la base de donnée à importer: https://mega.nz/file/EGt32DRL#YXnXECUh1hOXZ7tCwhVQOQ6HWQMDuQB1Kah6T9a_eJk

ensuite importez la base de donnée fournie, il n'existe pas de commande en SQL pour importer un fichier directement,
donc il suffit de cliquer sur la base de donnée créé un peu plus tôt et de ce rendre sur "importer" dans les onglets supérieurs de MyPHPadmin puis
de choisir le fichier en .sql dans fichier à importer laisser toutes les options par defaut puis tout en bas cliquez sur "importer".

sinon en ligne de commande terminal:

mysql -u nom_utilisateur -p nom_de_la_base_de_donnée < garageautomobile.sql

ensuite la nouvelle base de donnée devrait apparaitre dans PHPmyAdmin, en cliquant dessus vous pourrez voir toutes les tables presentes à l'interieur.

sinon si vous souhaitez créer votre propre base:

dans le terminal à la racine du dossier projet, entrez cette commande: php bin/console make:migration 

puis : php bin/console doctrine:migrations:migrate


Dans le repertoire de l'application, fichier .env , vérifier que le nom de la base de donnée est le même que celle que vous avez créer dans PHPmyAdmin,
normalement, 

DATABASE_URL="mysql://root@127.0.0.1:3306/garageautomobile?serverVersion=10.11.2-MariaDB&charset=utf8mb4"


ensuite sous visual code par exemple, dans le terminal tapez la commande suivante en etant dans le repertoire racine du projet:

symfony serve -d

dans le terminal un rectangle vert avec l'adresse du serveur https://127.0.0.1:8000 va apparaitre,
copiez cette ligne dans le navigateur en ajoutant /accueil a la fin, vous arriverez sur la page d'accueil du site.


Pour tester les fonctionnalités du site, il y a deja 2 utilisateurs créés si vous avez importé la base fournie:

Administrateur: 
identifiant: admin@gmail.com
mot de passe: 123456

Employé:
identifiant: employe@gmail.com
mot de passe: 123456

Sinon si vous avez créé votre propre base, il faut créer l'administrateur:

Aller dans le controlleur : RegistrationController.php et décommentez la derniere partie du code "Ajouter admin"

ensuite dans le navigateur entrez l'adresse https://127.0.0.1/registeradmin

------------------------------------------------------------------------------------------------------------------------------------------------

Version en ligne:


Application disponible à cette adresse:

http://arcane-springs-06935-14402cc9d4dd.herokuapp.com/accueil

Administrateur: admin@gmail.com / mdp: 123456

Utilisateur: employe@gmail.com / mdp: 123456


Amusez vous bien :)









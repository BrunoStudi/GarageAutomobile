GARAGE AUTOMOBILE

V. Parrot

Pour tester l'application:

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

Apres avoir cloner le projet du github, lancer les commandes suivantes sur le terminal:

-	composer install
-	npm install
-	npm install vue bootstrap-vue bootstrap

Ensuite lancez Wamp server, attendez que tout les services soient prêt et allez dans la barre des taches, zone des notifications et cliquez avec le bouton gauche sur l'icone ressemblant à un W en vert puis PHPmyAdmin et PHPmyAdmin.

Connectez vous avec l'identifiant "root" et un mot de pass vide et choix du serveur "MySQL".
Créez une nouvelle base de donnée en vous rendant dans SQL au niveau de l'onglet superieur,
entrez la commende suivante: 

CREATE DATABASE garageautomobile;

Fichier SQL de la base de donnée à importer: https://mega.nz/file/EGt32DRL#YXnXECUh1hOXZ7tCwhVQOQ6HWQMDuQB1Kah6T9a_eJk

ensuite importez la base de donnée fournie, il n'existe pas de commande en SQL pour importer un fichier,
donc il suffit de cliquer sur la base de donnée créé un peu plus tôt et de ce rendre sur "importer" dans les onglets supérieurs de MyPHPadmin puis
de choisir le fichier en .sql dans fichier à importer laisser toutes les options par defaut puis tout en bas cliquez sur "importer".

sinon en ligne de commande terminal:

mysql -u username -p nom_de_la_base_de_donnée < fichier.sql

ensuite la nouvelle base de donnée devrait apparaitre dans PHPmyAdmin, en cliquant dessus vous pourrez voir toutes les tables presentes à l'interieur.







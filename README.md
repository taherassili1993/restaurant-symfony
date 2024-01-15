J'ai implementer une application de gestion des restaurants en utilisant Symfony 5, MySQL et PHP 7.4.29.

Demo: https://www.youtube.com/watch?v=l5ECtFvVyEc

1- Télécharger le code source en utlisant ssh: git clone git@github.com:taherassili1993/restaurant-symfony.git

2- Ouvrir xampp et lancer Apache et MySQL.

3- Installer les modules: cd cd restaurant-symfony puis composer install

4- creer la base de données:

php bin/console doctrine:database:create

php bin/console doctrine:migrations:diff

php bin/console doctrine:migrations:migrate

5- Lancer le serveur: symfony server:start

6- Acceder à notre app à partir le lien http://localhost:8000/

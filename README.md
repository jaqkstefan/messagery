Le projet est une application PHP tournant grace au framework Symfony 3. Donc toutes les commandes applicables � ce framework sont applicables au projet! Les configurations serveurs
sont � ins�rer dans le fichier app/config/config.yml.
Pour cr�er la base de donn�e c'est possible en ligne de commande avec la commande 
	php bin/console doctrine:database:create
Ensuite effectuer la commande
	php bin/console doctrine:schema:update --force 
pour mettre � jour les tables de la base de donn�es.
Pour cr�er un administrateur, c'est pour possible via une route en GET accessible uniquement en localhost pour des raisons de s�curit�! Cette route est 
/_create/username/prenom/nom/password
o� 
- username est le nom d'utilisateur
- nom est le nom de l'administrateur
- prenom est son pr�nom
- password est le mot de passe

L'acc�s se fait uniquement apr�s connexion par username et password.
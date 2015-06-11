=======
SERVEUR
=======
.. image:: http://geotrek.fr/images/logo-pne.png
    :target: http://www.ecrins-parcnational.fr
    


Pré-requis
===========

Vous devez disposer d'un serveur ou d'un hébergement mutualisé avec MySQL, PHP 5.4 et Apache2. Le mod_rewrite doit être activé

Si vous avez la main sur le serveur, cette documentation vous aidera à sa mise en place.

Si vous disposez d'un hébergement mutualisé, le serveur doit être prêt à l'utilisation (avec MySQL, PHP 5.4 et Apache2), passez alors directement à  :ref:`la rubrique INSTALLATION <installation-section>`.

* Ressources minimales du serveur :

Un serveur disposant d'au moins de 1 Go RAM et de 10 Go d'espace disque.

* Disposer d'un utilisateur linux (nommé ``followdem`` dans cette exemple et dont le répertoire est ainsi dans ``/home/followdem/``

  :: 
    
        sudo adduser --home /home/followdem followdem


* Récupérer le zip de l'application sur le Github du projet (`X.Y.Z à remplacer par le numéro de version souhaité <https://github.com/mPnEcrins/FollowDem/releases>`_) et dézippez le dans le répertoire de l'utilisateur linux : 

  ::
    
        cd /tmp
        wget https://github.com/PnEcrins/FollowDem/archive/vX.Y.Z.zip
        unzip vX.Y.Z.zip
        mkdir -p /home/followdem/monprojet
        cp master/* /home/followdem/monprojet
        cd /home/followdem

        
Installation et configuration du serveur
========================================

Installation pour Ubuntu.

:notes:

    Cette documentation concerne une installation sur Ubuntu 12.04 LTS. Elle devrait être valide sur Debian ou une version plus récente d'Ubuntu. Pour tout autre environemment les commandes sont à adapter.

.

:notes:

    L'utilisateur ``followdem`` est à remplacer par le nom de votre utilisateur linux si vous en avez choisi un différent.

.
Donnez les droits d'administrateur à l'utilisateur ``followdem`` :


  ::
   
     su - 
     usermod -g www-data followdem
     usermod -a -G root followdem
     adduser followdem sudo
     exit
    
    Fermer la console et la réouvrir pour que les modifications soient prises en compte
    
* Activer le mod_rewrite et redémarrer Apache :

  ::  
        
        sudo a2enmod rewrite
        sudo apache2ctl restart


Installation et configuration de MYSQL
==========================================

* Mise à jour des sources :

  ::  
    
        sudo apt-get update

* Installation de MySQL et création de l'utilisateur ``root`` avec le mot à passe à remplacer :

  ::
  
		apt-get install mysql-server mysql-client libmysqlclient15-dev mysql-common
		sudo mysqladmin -u root password Nouveau_mot_de_passe -p ""
		
* Ouvrir le fichier de configuration de MySQL pour le modifier :

  ::

		sudo vi /etc/mysql/my.cnf

Dans le fichier ``my.cnf``, modifier les lignes de la façon suivante :
	
  ::
  
		language = /usr/share/mysql/french
		key_buffer = 32M
		query_cache_limit = 2M
		#log_bin = /var/log/mysql/mysql-bin.log
		#expire_logs_days = 10
		log_slow_queries = /var/log/mysql/mysql-slow.log
		long_query_time = 2
		default-character-set = utf8
		default-collation = utf8_general_ci
		default-character-set = utf8

* Rechargez ensuite le serveur :

  ::

	  /etc/init.d/mysql reload
		
* Création d'un utilisateur MySQL (nom et mot de passe à replacer par vos valeurs) :

  ::
  
		CREATE USER "nom_utilisateur"@"localhost";
		SET password FOR "nom_utilisateur"@"localhost" = password('mot_de_passe');

* Création d'une base de donnéees MySQL (nom à remplacer) :

  ::
  
		CREATE DATABASE nom_de_la_base;
	
* Pour se placer dans la base, tapez dans MySQL :

  ::
  
	  USE nom_de_la_base;	
		
		
* Attribution des droits à l'utilisateur MySQL :

  ::
  
		GRANT ALL ON nom_de_la_base.* TO "nom_utilisateur"@"localhost";
	

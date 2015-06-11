=======
SERVEUR
=======
.. image:: http://geotrek.fr/images/logo-pne.png
    :target: http://www.ecrins-parcnational.fr
    


Pré-requis
===========

vous devez disposer d'un serveur ou d'un hébergement avec mysql, php5.4 et apache. Le mod_rewrite doit être activé

Si vous avez la main sur le serveur, cette documentation peut vous aider à sa mise en place.

Si vous disposez d'un hébergement, le serveur doit être prêt à l'utilisation.

* Ressources minimales du serveur :

Un serveur disposant d'au moins de 1 Go RAM et de 10 Go d'espace disque.


* disposer d'un utilisateur linux que vous pouvez nommé par exemple ``followdem``. Le répertoire de cet utilisateur ``followdem`` doit être dans ``/home/followdem``

    :: 
    
        sudo adduser --home /home/followdem followdem


* récupérer le zip de l'application sur le Github du projet

    ::
    
        cd /tmp
        wget https://github.com/PnEcrins/FollowDem/archive/master.zip
        unzip master.zip
        mkdir -p /home/followdem/monprojet
        cp master/* /home/followdem/monprojet
        cd /home/followdem

        
Installation et configuration du serveur
========================================

Installation pour ubuntu.

:notes:

    Cette documentation concerne une installation sur Ubuntu 12.04 LTS. Elle devrait être valide sur Debian ou une version plus récente d'Ubuntu. Pour tout autre environemment les commandes sont à adapter.

.

:notes:

    Durant toute la procédure d'installation, travailler avec l'utilisateur ``followdem``. Ne changer d'utilisateur que lorsque la documentation le spécifie.

.

  ::
   
    su - 
    usermod -g www-data followdem
    usermod -a -G root followdem
    adduser followdem sudo
    exit
    
    Fermer la console et la réouvrir pour que les modifications soient prises en compte
    
* Activer le mod_rewrite et redémarrer apache

  ::  
        
        sudo a2enmod rewrite
        sudo apache2ctl restart


Installation et configuration de MYSQL
==========================================

* Mise à jour des sources

  ::  
    
        sudo apt-get update

* Configuration MYSQL

  ::
    
        TODO

* Création d'un utilisateur MYSQL

  ::
    
        TODO   

* Création d'une base de donnéees MYSQL

  ::
	
		TODO
		
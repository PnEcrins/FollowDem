=======
SERVEUR
=======
.. image:: http://geotrek.fr/images/logo-pne.png
    :target: http://www.ecrins-parcnational.fr
    


Pré-requuis
===========

vous devez disposer d'un serveur ou d'un hébergement avec mysql, php5.4 et apache. Le mod_rewrite doit être activé

Si vous avez la main sur le serveur, cette documentation peut vous aider à sa mise en place.

Si vous disposez d'un hébergement, le serveur doit être prêt à l'utilisation.

* Ressources minimales du serveur :

Un serveur disposant d'au moins de 1 Go RAM et de 10 Go d'espace disque.


* disposer d'un utilisateur linux que vous pouvez nommé par exemple ``follodem``. Le répertoire de cet utilisateur ``follodem`` doit être dans ``/home/follodem``

    :: 
    
        sudo adduser --home /home/follodem follodem


* récupérer le zip de l'application sur le Github du projet

    ::
    
        cd /tmp
        wget https://github.com/PnEcrins/FollowDem/archive/master.zip
        unzip master.zip
        mkdir -p /home/follodem/monprojet
        cp master/* /home/follodem/monprojet
        cd /home/follodem

        
Installation et configuration du serveur
========================================

Installation pour ubuntu.

:notes:

    Cette documentation concerne une installation sur Ubuntu 12.04 LTS. Elle devrait être valide sur Debian ou une version plus récente d'Ubuntu. Pour tout autre environemment les commandes sont à adapter.

.

:notes:

    Durant toute la procédure d'installation, travailler avec l'utilisateur ``follodem``. Ne changer d'utilisateur que lorsque la documentation le spécifie.

.

  ::
   
    su - 
    usermod -g www-data follodem
    usermod -a -G root follodem
    adduser follodem sudo
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

* Installation de PostreSQL/PostGIS 

    ::
    
        TODO
        
* configuration MYSQL

    ::
    
        TODO

* Création d'un utilisateur MYSQL

    ::
    
        TODO   

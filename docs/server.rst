=======
SERVEUR
=======
.. image:: http://geonature.fr/img/logo-pne.jpg
    :target: http://www.ecrins-parcnational.fr



Pré-requis
===========

Vous devez disposer d'un serveur ou d'un hébergement mutualisé avec MySQL ou PostgreSQL, PHP 7 et Apache2.

Si vous avez la main sur le serveur, cette documentation vous aidera à sa mise en place.

L'application supporte l'utilisation du Système de Gestion de Bases de Données PostgreSQL et Mysql.

Cependant la partie MySql, utilisée pour les versions de l'application jusqu'à '0.3.0' n'a pas été testé pour cette version de l'application.


Si vous disposez d'un hébergement mutualisé, le serveur doit être prêt à l'utilisation (avec PostgreSQL, PHP 7.3 et Apache2), passez alors directement à la rubrique INSTALLATION.

* Ressources minimales du serveur :

Un serveur disposant d'au moins de 1 Go RAM et de 10 Go d'espace disque.

* Disposer d'un utilisateur linux (nommé ``followdem`` dans cette exemple et dont le répertoire est ainsi dans ``/home/followdem/``)

  ::

        sudo adduser --home /home/followdem followdem



Installation et configuration du serveur
========================================

Installation pour Ubuntu.

:notes:

    Cette documentation concerne une installation sur Ubuntu 18.04 LTS. Elle devrait être valide sur Debian ou une version plus récente d'Ubuntu. Pour tout autre environemment les commandes sont à adapter.

.

:notes:

    L'utilisateur ``followdem`` est à remplacer par le nom de votre utilisateur linux si vous en avez choisi un différent.


* Assignez le rôle d'administrateur à l'utilisateur ``followdem`` :


  ::

     sudo usermod -g www-data followdem
     sudo usermod -a -G root followdem
     sudo adduser followdem sudo
     exit

Fermer la console et la réouvrir pour que les modifications soient prises en compte.

* Mise à jour des sources applicatives :

  ::

        sudo apt-get update

* Installer Apache :

  ::

        sudo apt-get install apache2

* Activer le mod_rewrite et redémarrer Apache :

  ::

        sudo a2enmod rewrite
        sudo apache2ctl restart


Installation de PHP et ses librairies
=====================================

::

	sudo apt-get install php php7.3-common libapache2-mod-php7.3 php7.3-cli php7.3-dev
  sudo apt install php7.3-pgsql php-pgsql
	sudo apt-get install php7.3-imap
	sudo phpenmod imap
	sudo service apache2 restart


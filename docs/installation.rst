===========
APPLICATION
===========
.. image:: http://geotrek.fr/images/logo-pne.png
    :target: http://www.ecrins-parcnational.fr
    
Création des tables de la base de données MySQL
===============================================

Sur phpMyAdmin
--------------

Se placer dans la BDD de FollowDem puis dans l’onglet "Importer" de phpMyAdmin.

Cliquez sur “Choisissez un fichier” et sélectionner le fichier ``data/FollowDem_DataBase.sql`` qui est le script de création des tables.
	
Ensuite sélectionnez ``utf-8`` comme Jeu de caractères du fichier, autorisez l’importation partielle, sélectionnez ``SQL`` comme Format.
	
Enfin, cliquez sur ``Exécuter``

Votre base de données est maintenant opérationnelle et sans données.
	
Vous pouvez aussi importer un jeu de données exemple en effectuant les mêmes étapes que ci-dessus, mais en sélectionnant le fichier ``data/FollowDem_DataSet.sql``.

Sur un serveur
--------------

Se placer dans le répertoire ``data`` de l'application (en remplacant ``followdem`` par le nom de votre utilisateur Linux et ``monprojet`` par le répertoire où vous avez placer l'application FollowDem) :

::

	cd /home/followdem/monprojet/data

Créer la BDD MySQL (en remplacant par vos valeurs d'utilisateur MySQL et de nom de BDD) :
	
::

	mysql -unomUtilisateur -pmotDePasse
	use nomDeLaBase;
	source FollowDem_DataBase.sql;
		
Comme sur phpMyAdmin, si vous souhaitez ajouter le jeu de données d'exemple, saisissez en plus la commande suivante :

::
	
	source FollowDem_DataSet.sql;

Installation du répertoire de l'application
===========================================

* Récupérez le zip de l'application sur le Github du projet FollowDem : https://github.com/PnEcrins/FollowDem/archive/master.zip

* Extraire le contenu dans un répertoire au nom de votre projet à la racine du répertoire de publication web d'Apache.

Sur un serveur
--------------

* Récupérer le zip de l'application sur le Github du projet (`X.Y.Z à remplacer par le numéro de version souhaité <https://github.com/mPnEcrins/FollowDem/releases>`_) et dézippez le dans le répertoire de l'utilisateur linux : 

  ::
    
        cd /tmp
        sudo wget https://github.com/PnEcrins/FollowDem/archive/vX.Y.Z.zip
        sudo unzip vX.Y.Z.zip
        sudo mkdir -p /home/followdem/monprojet
        sudo cp FollowDem-master/* /home/followdem/monprojet
        cd /home/followdem

Configuration de l'application
==============================
    
Copier et renommer le fichier d'exemple de configuration de la carto ``carto.php.sample`` en ``carto.php``

::

        cd /home/followdem/monprojet/config
        cp carto.php.sample carto.php

Copier et renommer le fichier d'exemple de configuration de l'application ``config.php.sample`` en ``config.php``
    
::

        cp config.php.sample config.php
        cd ..

Editer les fichiers ``carto.php`` et ``config.php`` pour définir les paramètres de connexion à votre base de données, ainsi que tous les paramètres utiles à une personnalisation de votre application.
    
FONDS CARTOGRAPHIQUES
=====================

3 types de fonds cartographiques peuvent être utilisés dans l'application :
 
- Fonds IGN en utilisant l'API du Geoportail.

- Fonds OpenStreetMap.

- Fonds Google Maps.

* Allez à la ligne 323 du fichier *config.php*

Vous avez la possibilité d'ajouter un fond cartographique en respectant la nomenclature utilisée au dessus.

Vous pouvez aussi choisir quel fond vous souhaitez utiliser par défaut, en modifiant la ligne suivante :

::
	
		$config['leaflet_fonds_carte_defaut'] = "OSM";

Vous avez aussi la possibilité d'attacher les fonds de cartes Google avec le paramètre ligne 393.

Fonds IGN Geoportail
--------------------

Commencez par commander une clé IGN.
Si vous êtes un établissement public, vous disposez de la licence géoservices IGN pour usage grand public - gratuite

Avec les couches suivantes : 

* WMTS-Géoportail - Cartes IGN
* WMTS-Géoportail - Scan IGN
* WMTS-Géoportail - Orthophoto IGN

Pour cela, il faut que vous disposiez d'un compte IGN pro. (http://professionnels.ign.fr)
Une fois connecté au site: 

* aller dans nouvelle commande

* choisir Géoservices IGN : Pour le web dans la rubrique "LES GÉOSERVICES EN LIGNE"

* cocher l'option "Pour un site internet grand public"

* cocher l'option "Licence géoservices IGN pour usage grand public - gratuite"

* saisir votre url. Attention, l'adresse doit être précédée de http://

* Finisser votre commande en selectionnant les couches d'intéret et en acceptant les différentes licences.


Une fois que votre commande est prète saisissez la valeur de la clé IGN reçue dans le fichier config/config.php : remplacer dans l'url la chaine 'maCleIgn' dans la partie 'leaflet_fonds_carte' "IGNCARTE"=>

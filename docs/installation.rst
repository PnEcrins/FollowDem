============
INSTALLATION
============
.. image:: http://geotrek.fr/images/logo-pne.png
    :target: http://www.ecrins-parcnational.fr
    
Création des tables de la base de données MySQL
===============================================

Avec phpMyAdmin
--------------

Se placer dans la BDD de FollowDem puis dans l’onglet ``Importer`` de phpMyAdmin.

Cliquez sur ``Choisissez un fichier`` et sélectionner le fichier ``data/FollowDem_DataBase.sql`` qui est le script de création des tables.
	
Ensuite sélectionnez ``utf-8`` comme Jeu de caractères du fichier, autorisez l’importation partielle, sélectionnez ``SQL`` comme Format.
	
Enfin, cliquez sur ``Exécuter``

Votre base de données est maintenant opérationnelle et sans données.
	
Vous pouvez aussi importer un jeu de données exemple en effectuant les mêmes étapes que ci-dessus, mais en sélectionnant le fichier ``data/FollowDem_DataSet.sql``.

En ligne de commande
--------------------

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

Avec un logiciel FTP ou SSH (WinSCP, Filezilla...)
--------------------------------------------------

* Récupérez le ZIP de la version souhaitée de l'application sur le Github du projet FollowDem (https://github.com/PnEcrins/FollowDem/releases)

* Extraire le contenu dans un répertoire au nom de votre projet à la racine du répertoire de publication web d'Apache du serveur.

En ligne de commande
--------------------

* Récupérer le zip de l'application sur le Github du projet (`X.Y.Z à remplacer par le numéro de version souhaité <https://github.com/PnEcrins/FollowDem/releases>`_) et dézippez le dans le répertoire de l'utilisateur linux : 

  ::
    
        cd /tmp
        sudo wget https://github.com/PnEcrins/FollowDem/archive/vX.Y.Z.zip
        sudo unzip vX.Y.Z.zip
        sudo mkdir -p /home/followdem/monprojet
        sudo cp FollowDem-master/* /home/followdem/monprojet
        cd /home/followdem

Configuration de l'application
==============================

Créer le répertoire ``/csv`` à la racine de l'application, créer le fichier ``tracked_objects.csv`` à l'intérieur de ce répertoire.
Ensuite, créer le répertoire ``/csv`` dans le répertoire ``/tmp`` (ce sera ce dossier qui recevra les fichiers txt contenus dans les pièces jointes des emails envoyés par le satellite.

Copier et renommer le fichier d'exemple de configuration de l'application ``config.php.sample`` en ``config.php``
    
::

        cd /home/followdem/monprojet/config
        cp config.php.sample config.php
        cd ..

Editer le fichier ``config.php`` pour définir les paramètres de connexion à votre base de données, ainsi que tous les paramètres utiles à une personnalisation de votre application.

Voir la rubrique CONFIGURATION pour le détail des paramètres.
    
Fonds cartographiques
=====================

3 types de fonds cartographiques peuvent être utilisés dans l'application :
 
- Fonds IGN en utilisant l'API du Geoportail.

- Fonds OpenStreetMap.

- Fonds Google Maps.

La configuration des fonds à utiliser se fait dans le fichier ``/config/config.php`` à partir de la ligne 323. Voir rubrique CONFIGURATION pour le détail des paramètres.

Vous avez la possibilité d'ajouter un fond cartographique en respectant la nomenclature utilisée au dessus.

Vous pouvez aussi définir le fond vous souhaitez utiliser par défaut, en modifiant la ligne suivante du fichier ``/config/config.php`` :

::
	
		$config['leaflet_fonds_carte_defaut'] = "OSM";

Vous avez aussi la possibilité d'utiliser les fonds de carte Google Maps avec le paramètre ligne 393 du fichier ``/config/config.php``.

Fonds IGN Geoportail
--------------------

Commencez par commander une clé IGN.
Si vous êtes un établissement public, vous disposez de la licence géoservices IGN pour usage grand public - gratuite

Nous conseillons les couches suivantes : 

* WMTS-Géoportail - Cartes IGN
* WMTS-Géoportail - Scan IGN
* WMTS-Géoportail - Orthophoto IGN

Pour cela, il faut que vous disposiez d'un compte IGN pro. (http://professionnels.ign.fr)
Une fois connecté au site: 

* aller dans Nouvelle commande

* choisir Géoservices IGN : Pour le web dans la rubrique "LES GÉOSERVICES EN LIGNE"

* cocher l'option "Pour un site internet grand public"

* cocher l'option "Licence géoservices IGN pour usage grand public - gratuite"

* saisir votre url. Attention, l'adresse doit être précédée de http://

* Finir votre commande en selectionnant les couches souhaitées et en acceptant les différentes licences.


Une fois que votre commande est prète, saisissez la valeur de la clé IGN reçue dans le fichier ``config/config.php`` : remplacer la chaine ``maCleIgn`` dans le paramètre ``$config['leaflet_fonds_carte']`` dans l'URL des fonds IGN Geoportail.


Cache serveur
=============

Smarty s'occupe de sauvegarder le cache sur le serveur et garde ce cache pendant deux heures (durée paramétrable avec ``$config['smarty_cache_lifetime']`` dans le fichier ``config/config.php``).

Le cache est sauvegardé dans deux dossiers différents : ``/templates_c`` et ``/cache``.

Lorsque vous effectuez des modifications dans l'application, il se peut que les changements ne se soient pas enregistrés dans les dossiers de cache.
Pour voir ces modifications appliquées, il vous faudra vider les dossiers ``/templates_c`` et ``/cache``.

===========
APPLICATION
===========
.. image:: http://geotrek.fr/images/logo-pne.png
    :target: http://www.ecrins-parcnational.fr
    
Création de la base de données MYSQL
====================================

Sur phpMyAdmin.
	::
		


	Allez dans l’onglet "Importer" depuis la page d’accueil de phpMyAdmin.

	Cliquez sur “Choisissez un fichier” et sélectionner le fichier ``data/FollowDem_DataBase.sql`` qui est le script de création des tables.
	
	Ensuite sélectionnez “utf-8” comme Jeu de caractères du fichier, autorisez l’importation partielle, sélectionnez le “SQL” comme Format.
	
	Enfin, cliquez sur “Exécuter”

	Votre base de données est maintenant opérationnelle.
	Si vous voulez, vous pouvez importer un jeu d’essai en effectuant les mêmes étapes que ci-dessus, mais en sélectionnant le fichier ``data/FollowDem_DataSet.sql``.

Sur un serveur.

	::

		cd /home/followdem/monprojet/data
		mysql -unomUtilisateur -pmotDePasse
		use nomDeLaBase;
		source FollowDem_DataBase.sql;
		
	Idem que sur phpMyAdmin, si vous souhaitez ajouter un jeu d’essai, saisissez en plus la commande suivante :
	
	::
	
		source FollowDem_DataSet.sql;

Installation du répertoire de l'application
===========================================

* Récupérez le zip de l'application sur le Github du projet FollowDem : https://github.com/PnEcrins/FollowDem/archive/master.zip

* Extraire le contenu dans un répertoire au nom de votre projet à la racine du répertoire de publication web d'apache.

Sur un serveur.

    ::
    
        cd /tmp
        wget https://github.com/PnEcrins/FollowDem/archive/master.zip
        unzip master.zip
        mkdir -p /home/followdem/monprojet
        cp master/* /home/followdem/monprojet
        rm master.zip
        cd /home/followdem
        
	
Configuration de l'application
==============================
    
Copier et renommer le fichier ``carto.php.sample`` en ``carto.php``
    
Copier et renommer le fichier ``config.php.sample`` en ``config.php``
    
    ::
    
        cd /home/followdem/monprojet/config
        cp carto.php.sample carto.php
        cp config.php.sample config.php
        cd ..

Editer ces fichiers et mettre à jour les paramètres de connexion à votre base de données, ainsi que tous les paramètres utiles à une personnalisation de votre application.
    
    
Clé IGN
=======
Commander une clé IGN de type : Licence géoservices IGN pour usage grand public - gratuite
Avec les couches suivantes : 

* WMTS-Géoportail - Cartes IGN

Pour cela, il faut que vous disposiez d'un compte IGN pro. (http://professionnels.ign.fr)
Une fois connecté au site: 

* aller dans nouvelle commande

* choisir Géoservices IGN : Pour le web dans la rubrique "LES GÉOSERVICES EN LIGNE"

* cocher l'option "Pour un site internet grand public"

* cocher l'option "Licence géoservices IGN pour usage grand public - gratuite"

* saisir votre url. Attention, l'adresse doit être précédée de http://

* Finisser votre commande en selectionnant les couches d'intéret et en acceptant les différentes licences.


Une fois que votre commande est prète saisissez la valeur de la clé IGN reçue dans le fichier config/config.php : remplacer dans l'url la chaine 'maCleIgn' dans la partie 'leaflet_fonds_carte' "IGNCARTE"=>
===========
APPLICATION
===========

Création de la base de données MYSQL
====================================

    TODO

    
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

    TODO
    
    
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
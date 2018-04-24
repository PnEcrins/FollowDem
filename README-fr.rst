FollowDem
=========

Application web cartographique permettant de suivre le déplacement d'objets équipés d'un GPS. 

Utilisée pour le suivi GPS des bouquetins du Parc national des Ecrins : `<http://bouquetins.ecrins-parcnational.fr>`_

.. image :: docs/img/screenshot-bouquetins-pne.jpg
    :target: http://bouquetins.ecrins-parcnational.fr
    
English version of this presentation : `<https://github.com/PnEcrins/FollowDem/blob/master/README.rst>`_

Technologies
------------

- Langages : PHP, HTML, JS, CSS
- BDD : MySQL / PDO
- Serveur : Debian ou Ubuntu
- Framework carto : `Leaflet <http://leafletjs.com>`_
- Framework CSS : `Bootstrap <http://getbootstrap.com>`_
- Template : `Bootleaf <https://github.com/bmcbride/bootleaf>`_
- Gestion des templates et du cache : `Smarty <http://www.smarty.net>`_
- Fonds rasters : Geoportail, OpenStreetMap, Google Maps, WMS

Présentation
------------

**Principe général** : 

L'application permet de suivre la position et le déplacement de plusieurs objets équipés d'un GPS. 

Les objets ont chacun un identifiant. Ils transmettent tous leur position GPS à un satellite à intervalles réguliers. 

Il faut ensuite récupérer ces positions GPS des objets pour les intégrer dans la base de données MySQL. Pour cela un fichier TXT par position et par objet est envoyé à une boite email.

Une tâche (``import_imap_csv`` dans le fichier ``/classes/controler/controler.class.php``) permet de : 

- Se connecter à cette boite email et d'en extraire les fichiers TXT en pièce-jointe des emails
- Copier ces fichiers TXT dans le répertoire ``tmp/csv``
- Supprimer les emails une fois les fichiers TXT copiés sur le serveur
- Importer les nouvelles positions des différents objets (si ceux-ci existent dans la BDD avec un identifiant commun) dans un fichier CSV (``/csv/tracked_objects.csv``)
- Supprimer les fichiers TXT temporaires une fois qu'ils ont été traités
- Importer les nouvelles positions dans la BDD MySQL depuis le fichier ``/csv/tracked_objects.csv``
- Vider le fichier ``/csv/tracked_objects.csv``

Cette tache peut être lancée manuellement ou par un CRON lancé autmatiquement à intervalle régulier.

D'autres manières de remplir ce CSV pourraient être envisagées : 

- Remplir directement le fichier CSV automatiquement ou à la main
- Importer les fichiers TXT dans le répertoire ``tmp/csv`` sans passer par une connection à une boite email.

Installation
------------

Consulter la documentation :  `<http://followdem.rtfd.org>`_

Auteurs
-------

Parc national des Ecrins

- Fabien Selles
- Thibault Romanin
- Gil Deluermoz
- Camille Monchicourt

License
-------

* OpenSource - BSD
* Copyright (c) 2015 - Parc National des Écrins


.. image:: http://geonature.fr/img/logo-pne.jpg
    :target: http://www.ecrins-parcnational.fr

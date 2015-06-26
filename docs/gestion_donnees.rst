===================
GESTION DES DONNEES
===================

Après avoir installé et configuré l'application, vous devez créer vos objets suivis dans la base de données.

Tout d'abord, sélectionnez la BDD de votre application dans phpMyAdmin.

CAS n°1 : Ajouter un objet dont l'émetteur GPS n'a jamais été utilisé
=====================================================================

Insérez une nouvelle ligne dans la table ``tracked_objects`` :

• ``id`` : correspond à l'identifiant numérique de l'émetteur GPS.

• ``nom`` : nom de l'objet.

• ``date_creation`` : date du jour ou laisser vide.

• ``date_maj`` : laisser vide (renseigné automatiquement à chaque import de données).

• ``active`` : désactive l'affichage d'un objet qui ne renvoie pas de données GPS. 

Attention mettre ``0`` dans le champs ``active`` ne signifie pas que l'objet sera désactivé du site pour toujours mais qu'il n'y apparaît plus tant que de nouvelles données satellites ne sont pas disponibles.

Si des données correspondantes à l'émetteur GPS sont de nouveau transmises l'objet sera réactivé automatiquement.

Ensuite, insérez 4 nouvelles entrées dans la table ``objects_features`` (une entrée par champ ``nom_prop``) :

• ``id_tracked_objects`` : correspond à l'identifiant numérique de l'émetteur GPS (sans le T5HS- devant)

• ``nom_prop`` : peut avoir 4 valeurs différentes :

- ``couleurD`` : couleur de la boucle sur l'oreille droite,

- ``couleurG`` : couleur de la boucle sur l'oreille gauche,

- ``naissance`` : année de naissance

- ``sexe`` : M ou F

• ``valeur_prop`` : valeur selon ``nom_prop`` :

- ``couleurD`` ou ``couleurG`` : couleur héxadecimale précédée de # (ex : #FF4574)

- ``naissance`` : année au format numérique (ex : 2010)

- ``sexe`` : F ou M

Il ne reste plus qu'à lancer un import des données existantes si des données ont déjà été transmises après la pose de l'émetteur GPS sur l'objet traqué.

Ces données se trouvent dans les fichiers TXT du répertoire ``/tmp/csv``.

Il faut donc exécuter le script http://mon-domaine.com/controler/import_imap_csv. Les données sont intégrées dans la table ``gps_data``. Voir rubrique PRINCIPES DE L'APPLICATION dans la documentation CONFIGURATION.

Il se peut que le fichier contienne des données de test avant la pose de l'émetteur GPS, il faut donc éxecuter la requête suivante dans la BDD pour les supprimer (en remplacant ``id_emetteurGPS`` par la valeur numérique souhaitée) :

::

	DELETE FROM `gps_data` WHERE `id_tracked_objects` = 'id_emetteurGPS' AND `dateheure` > 'date_de_pose';
		
CAS n°2 : Ajout d'un nouvel objet dont l'émetteur GPS a déjà été utilisé sur un autre objet
===========================================================================================

Si l'émetteur GPS a déjà été utilisé il convient de supprimer toutes les données antérieures à la nouvelle date de pose de l'émetteur GPS (en remplacant ``id_emetteurGPS`` par la valeur numérique souhaitée).

::

	DELETE FROM `gps_data` WHERE `id_tracked_objects` = 'id_emetteurGPS' AND `dateheure` > 'date_de_pose';
		
Si vous souhaitez conserver les données de l'ancien objet, vous pouvez effectuer la requête suivante pour renommer son identifiant (O pour OLD) :

::

	UPDATE `gps_data` SET `id_tracked_objects` = 'id_objet_O' WHERE `id_tracked_objects` = 'id_objet';
		
Ensuite reprenez les étapes du cas n°1.

CAS n°3 : Un objet change d'émetteur GPS
========================================

Modifiez l'identifiant de l'émetteur GPS dans la table ``tracked_objects``, pour ceci vous avez juste à modifier la ligne avec l'id souhaité.

Par la suite, modifiez l'identifiant de l'émetteur GPS dans la table ``objects_features``, vous devez modifier 4 lignes comme dans le cas n°1.

Sinon, tapez la requête suivante (en remplacant ``id_ancien_emetteurGPS`` et ``id_nouvel_emetteurGPS`` par les id souhaités) :

::

	UPDATE `objects_features` SET `id_tracked_objects` = 'id_ancien_emetteurGPS' WHERE `id_tracked_objects` = 'id_nouvel_emetteurGPS';
		
Enfin, supprimez les données datant d'avant la pose de l'émetteur GPS (en remplacant ``id_emetteurGPS``) :

::

	DELETE FROM `gps_data` WHERE `id_tracked_objects` = 'id_emetteurGPS' AND `dateheure` > 'date_de_pose';
		
Très important, si vous souhaitez conserver les anciennes données de l'objet, tapez la requête suivante (en remplacant ``id_ancien_emetteurGPS`` et ``id_nouvel_emetteurGPS``) :

::

	UPDATE `gps_data` SET `id_tracked_objects` = 'id_ancien_emetteurGPS' WHERE `id_tracked_objects` = 'id_nouvel_emetteurGPS';
		
Mais si vous souhaitez les supprimer, privilégiez plutôt la requête suivante (en remplacant ``id_ancien_emetteurGPS``) :

::

	DELETE FROM `gps_data` WHERE `id_tracked_objects` = 'id_ancien_emetteurGPS';
		
Tout comme dans le cas n°1, si vous voulez importer des données existantes, exécutez le script suivant : http://mon-domaine.com/controler/import_imap_csv.

CAS n°4 : Ne plus afficher un objet
===================================

2 solutions s'offrent à vous :

- Vous voulez conserver les anciennes données :

Il suffit pour cela de renommer l'identifiant dans la table ``tracked_objects``.

Et après il faut mettre le champ ``active`` à ``0``.

- Vous souhaitez supprimer définitivement les données :

Exécutez les requêtes suivantes (en remplacant ``id_emetteurGPS``) :

::

	DELETE FROM `tracked_objects` WHERE `id` = 'id_emetteurGPS';
	DELETE FROM `objects_features` WHERE `id_tracked_objects` = 'id_emetteurGPS';
	DELETE FROM `gps_data` WHERE `id_tracked_objects` = 'id_emetteurGPS';

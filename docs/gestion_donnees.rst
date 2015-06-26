===================
GESTION DES DONNEES
===================

Après avoir configuré votre serveur, si vous avez besoin d'effectuer des tâches sur la base de données, référez vous à ce document.

Tout d'abord, sélectionnez la base de votre application.

CAS n°1 : Ajouter un objet dont le collier n'a jamais été utilisé
=================================================================

Insérez une nouvelle ligne dans la table tracked_objects :

• ``id`` : correspond à l'identifiant numérique du collier.

• ``nom`` : nom de l'objet.

• ``date_creation`` : date du jour ou laisser vide.

• ``date_maj`` : laisser vide.

• ``active`` : désactive l'affichage d'un objet qui ne renvoie pas de données satellite. 

Attention mettre ``0`` ne signifie pas que l'objet sera désactivé du site pour toujours mais qu'il n'y apparaît plus tant que de nouvelles données satellites ne sont pas disponibles.

Si des données correspondantes au collier sont de nouveau transmises l'objet sera réactivé automatiquement.

Ensuite, insérez 4 nouvelles entrées dans la table objects_features (une entrée par champ ``nom_prop``) :

• ``id_tracked_objects`` : correspond à l'identifiant numérique du collier (sans le T5HS- devant)

• ``nom_prop`` : peut avoir 4 différentes valeur :

- ``couleurD`` : couleur de la boucle sur l'oreille droite,

- ``couleurG`` : couleur de la boucle sur l'oreille gauche,

- ``naissance`` : année de naissance

- ``sexe``

• ``valeur_prop`` : valeur selon ``nom_prop`` :

- ``couleurD`` ou ``couleurG`` : couleur héxadecimale précédée de # (ex : #FF4574)

- ``naissance`` : année au format numérique (ex : 2010)

- ``sexe`` : F ou M

Il ne reste plus qu'à faire un import manuel des données existantes si des données ont déjà été transmises après la pose du collier sur l'objet traqué.

Ces données se trouvent dans le répertoire ``/tmp/csv`` dans les fichier TXT.

Il faut donc exécuter le script http://mon-domaine.com/controler/import_imap_csv. Les données sont importées dans la table ``gps_data``.

Il se peut que le fichier contienne des données avant la pose du collier, il faut donc éxecuter dans MYSQL la requête suivante :

	::
		DELETE FROM `gps_data` WHERE `id_tracked_objects` = 'id_collier' AND `dateheure` > 'date_de_pose';
		
CAS n°2 : Ajout d'un nouvel objet dont le collier a déjà été utilisé sur un autre objet
=======================================================================================

Si le collier a déjà été utilisé il convient de supprimer toutes les données antérieures à la nouvelle date de pose pour le collier.

	::
		DELETE FROM `gps_data` WHERE `id_tracked_objects` = 'id_collier' AND `dateheure` > 'date_de_pose';
		
Si vous souhaitez conserver les données de l'ancien objet, vous pouvez effectuer la requête suivante :

	::
		UPDATE `gps_data` SET `id_tracked_objects` = 'id_objet_O' WHERE `id_tracked_objects` = 'id_objet';
		
Ensuite reprenez les étapes du cas n°1.

CAS n°3 : Un objet change de collier
====================================

Modifiez l'identifiant du collier dans la table ``tracked_objects``, pour ceci vous avez juste à éditer la ligne avec l'id souhaité.

Par la suite, modifiez l'identifiant du collier dans la table ``objects_features``, vous devez éditer 4 lignes comme dans le cas n°1.

Sinon, tapez la requête suivante :

	::
		UPDATE `objects_features` SET `id_tracked_objects` = 'id_ancien_collier' WHERE `id_tracked_objects` = 'id_nouveau_collier';
		
Enfin, supprimez les données datant d'avant la pose du collier :

	::
		DELETE FROM `gps_data` WHERE `id_tracked_objects` = 'id_collier' AND `dateheure` > 'date_de_pose';
		
Très important, si vous souhaitez conserver les anciennes données de l'objet, tapez la requête suivante :

	::
		UPDATE `gps_data` SET `id_tracked_objects` = 'id_ancien_collier' WHERE `id_tracked_objects` = 'id_nouveau_collier';
		
Mais si vous souhaitez les supprimer, privilégiez plutôt la requête suivante :

	::
		DELETE FROM `gps_data` WHERE `id_tracked_objects` = 'id_ancien_collier';
		
Tout comme dans le cas n°1, si vous voulez importer des données existantes, exécutez le script suivant : http://mon-domaine.com/controler/import_imap_csv.

CAS n°4 : Ne plus afficher un objet
===================================

2 solutions s'offrent à vous :

- Vous voulez conserver les anciennes données :

Il suffit pour cela de renommer l'identifiant dans la table ``tracked_objects``.

Et après il faut mettre le champ ``active`` à ``0``.

- Vous souhaitez supprimer définitivement les données :

Exécutez les requêtes suivantes :

	::
		DELETE FROM `tracked_objects` WHERE `id` = 'id_collier';
		DELETE FROM `objects_features` WHERE `id_tracked_objects` = 'id_collier';
		DELETE FROM `gps_data` WHERE `id_tracked_objects` = 'id_collier';
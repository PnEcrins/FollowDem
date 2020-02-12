===================
GESTION DES DONNEES
===================

Après avoir installé et configuré l'application, vous devez créer vos objets suivis dans la base de données.

Pour cela vous devez installer l'application d'administration de FollowDem.


Gestion des données
===================

Il est conseillé d'installer l'application FollowDem-Admin (https://github.com/PnEcrins/FollowDem-admin) pour gérer les données.


CAS n°1 : Ajouter des données dont l'émetteur GPS n'a jamais été utilisé
========================================================================

Sur l'application FollowDem-Admin :

• Créer un nouveau type de dispositif ('device type') correspondant au type de l'émetteur GPS si celui-ci n'existe pas.
• Créer les attributes :
	- ``couleurD`` : couleur héxadecimale précédée de # (ex : #FF4574) de la boucle sur l'oreille droite,
	- ``couleurG`` : couleur héxadecimale précédée de # (ex : #FF4574) de la boucle sur l'oreille gauche,
	- ``sexe`` : M ou F

• Créer un nouveau dispositif ('device'), avec pour type de dispositif le type précédemment enregistré.
• Créer un nouveau animal ('animal').
	- ``nom`` : nom unique donné à l'animal,
	- ``naissance`` : année de naissance (ex : 2015)
	- ``date de capture`` : date de la capture de l'animal
	- ``dispositf`` : Ajouter le dispositif associé à l'animal
	- ``attributs`` : Ajouter la couleur de l'oreille gauche (``couleurG``), de l'oreille droite (``couleurD``) et le sexe de l'animal

Il ne reste plus qu'à lancer un import des données existantes si des données ont déjà été transmises après la pose de l'émetteur GPS sur l'objet traqué.

Ces données se trouvent dans les fichiers TXT du répertoire ``/tmp/csv``.

Il faut donc exécuter le script http://mon-domaine.com/controler/import_imap_csv. Les données sont intégrées dans la table ``t_gps_data``. Voir rubrique PRINCIPES DE L'APPLICATION dans la documentation CONFIGURATION.



CAS n°2 : Ajout d'un nouvel objet dont l'émetteur GPS a déjà été utilisé sur un autre objet
===========================================================================================

Si l'émetteur GPS a déjà été utilisé il convient de supprimer toutes les données antérieures à la nouvelle date de pose de l'émetteur GPS (en remplacant ``id_emetteurGPS`` par la valeur numérique souhaitée).

::

	DELETE FROM `gps_data` WHERE `id_tracked_objects` = 'id_emetteurGPS' AND `dateheure` > 'date_de_pose';


Lancer l'import des données existantes si des données ont déjà été transmises après la pose de l'émetteur GPS sur l'objet traqué.

Ces données se trouvent dans les fichiers TXT du répertoire ``/tmp/csv``.

Il faut donc exécuter le script http://mon-domaine.com/controler/import_imap_csv. Les données sont intégrées dans la table ``t_gps_data``. Voir rubrique PRINCIPES DE L'APPLICATION dans la documentation CONFIGURATION.

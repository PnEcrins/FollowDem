===================
GESTION DES DONNEES
===================

Après avoir installé et configuré l'application, vous devez créer vos objets suivis dans la base de données.

Pour cela vous devez installer l'application d'administration FollowDem-Admin.
Pour l'installation de l'application d'administration référez-vous à la documentation des dépôts github :
        - https://github.com/PnEcrins/FollowDem-admin
        - https://github.com/PnEcrins/FollowDem-admin-front


Gestion des données
===================

Exemple: Ajouter d'un animal dont l'émetteur GPS n'a jamais été utilisé
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


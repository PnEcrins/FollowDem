=========
CHANGELOG
=========

0.4.0 (unreleased)
------------------

**New features**

- US language file added
- Generic favicon

**Documentation**

- Update data management documentation

0.3.0 (2015-06-26)
------------------

**Nouvelles fonctionnalités**

- Généricité des pages d'info de l'application (dans /template/pages/fr/)
- Documentation de la Gestion des données
- Evolution des développements sur l'administration (formulaire LOGIN, connexion à la BDD, composants JQUERY UI...)

0.2.0 (2015-06-22)
------------------

**Nouvelles fonctionnalités**

- Premiers développements de l'interface d'administration des données
- Documentation de la possibilité d'importer des données directement depuis le CSV avec la tache ``url/controler/import_csv`` (sans passer par la connexion email et les fichiers TXT)

**Corrections de bug**

- Erreur de nom de variable dans ``api.class.php``
- Suppression de 2 fichiers inutiles dans ``/config/``
- Nettoyage des commentaires

0.1.0 (2015-06-18)
------------------

**Première version générique de l'application**

A partir de l'application BOUQUETINS DU PARC NATIONAL DES ECRINS (http://bouquetins.ecrins-parcnatonal.fr) développée de manière générique par @nienfba en 2013, @romthi38 a finalisé la dépersonnalisation en juin 2015 pour qu'elle puisse être publiée et ainsi être utilisée par d'autres structures, potentiellement dans des contextes différents (suivi GPS de rapaces ou de tout autre animal ou objet équipé d'un émetteur GPS).

**Fonctionnalités**

- Retrait de toutes les spécificités de l'application initiale "BOUQUETINS du PNE"
- Intégration de tous les fichiers de l'application
- Intégration d'un script de création de la BDD et d'intégration optionnelle d'un jeu de données d'exemple
- Réalisation d'une documentation complète (http://followdem.rtfd.org) pour l'installation du serveur, de l'application et de la BDD ainsi que la configuration de l'application.

=============
CONFIGURATION
=============

Principe de l'application
=========================

**Principe général** : 

L'application permet de suivre la position et le délacement de plusieurs objets équipés d'un GPS. 

Les objets ont chacun un identifiant. Ils transmettent tous leur position GPS à un satellite à intervalles réguliers. 

Il faut ensuite récupérer ces positions GPS des objets pour les intégrer dans la base de données MySQL. Pour cela un fichier TXT par position et par objet est envoyé à une boite email. 

Le fichier TXT (nommé ``T5HS-4183_2014-07-31_185705.txt`` où ``4183`` est l'identifiant de l'objet et les chiffres suivants sont la date et l'heure) est construit de la sorte :

::

    2014-07-31	20:57:05+0	44.989867	6.022400	(-)0
    
    Date	Time	TTF	Lat	Long	SAT´s	2D/3D	Alt	H-DOP	Temp	X	Y	
    2014-07-31	18:57:00	100	44.9901367	 6.0225950	6	3D	  2547	3.5	 14	 46	 29

Dans cet exemple, le fichier contient :

- la date et l'heure du relevé GPS
- le TTF (Time To First Fix, temps mis pour obtenir la position GPS de l'objet)
- la latitude et longitude en WGS84
- le nombre de satellites qui ont permis de définir la position
- si la position a été fournie en 2D ou en 3D
- l'altitude de la position
- le H-DOP (Dilution Of Precision, coefficient de précision de la position)
- la température (fournie par le GPS)
- X et Y (non utilisées)

Une tâche (``import_imap_csv`` dans le fichier ``/classes/controler/controler.class.php``) permet de : 

- Se connecter à cette boite email et d'en extraire les fichiers TXT en pièce-jointe des emails
- Copier ces fichiers TXT dans le répertoire ``tmp/csv``
- Supprimer les emails une fois les fichiers TXT copiés sur le serveur
- Importer les nouvelles positions des différents objets (si ceux-ci existent dans la BDD avec un identifiant commun) dans un fichier CSV (``/csv/tracked_objects.csv``)
- Supprimer les fichiers TXT temporaires une fois qu'ils ont été traités
- Importer les nouvelles positions dans la BDD MySQL depuis le fichier ``/csv/tracked_objects.csv``
- Vider le fichier ``/csv/tracked_objects.csv``

Cette tache peut être lancée manuellement (``url/controler/import_imap_csv``) ou par un CRON lancé autmatiquement à intervalle régulier.

Pour mettre en place le CRON qui va lancer cette tache toutes les heures, éditez la liste des CRON du serveur : 
::
	crontab -e

Ajouter cette ligne dans le fichier (en remplacant ``URL_FollowDem`` par l'URL de votre application) : 
::
	#BOUQUETINS Import des donnees toutes les heures
	0 */1 * * * wget http://URL_FollowDem/controler/import_imap_csv -O - >> /var/www/followdem/logs/imports.log

Les résultats de la tache lancée automatiquement toutes les heures seront écrits dans le fichier de log ``/logs/imports.log``.

D'autres manières de remplir ce CSV pourraient être envisagées : 

- Remplir directement le fichier CSV automatiquement ou à la main
- Importer les fichiers TXT dans le répertoire ``tmp/csv`` sans passer par une connexion à une boite email.

Ainsi une autre tache est disponible sans se connecter à une boite email, ni passer par des fichiers TXT : ``url/controler/import_csv``

- Elle recherche le fichier : ``csv/tracked_objects.csv``
- Puis importe selon la définition du tableau associatif ``$config['csv_colonne']`` (nom_donnee => index CSV) 

Dans notre cas, le fichier CSV est constitué des colonnes :

- Id de l'objet.
- Nom de l'objet.
- Date de l'envoi des données au satellite.
- Heure de l'envoi des données au satellite.
- TTF (pas utilisé)
- Latitude.
- Longitude.
- Nombre de satellites.
- 3D ou 2D. (si c'est on 3D on a l'altitude)
- Altitude de l'objet.
- H-DOP. (permet de connaître la fiabilité de la position)
- Température.
- X (pas utilisé)
- Y (pas utilisé)

Les colonnes et leur ordre dans le CSV sont configurables dans le paramètre ``$config['csv_colonne']`` du fichier ``/config/config.php``
Il est possible de définir des seuils de valeur pour lesquelles on ne souhaite pas intégrer les positions dans la BDD (Nombre de satellites trop faible, H-DOP trop élevé, latitude, longitude ou altitude incohérentes,...) avec le paramètre ``$config['csv_condition']`` dans le fichier ``/config/config.php``.

Configurer l'application
========================

Rendez vous dans le fichier ``/config/config.php``, c'est ce fichier qui est la base de la configuration de l'application.

Modifier nom de domaine de l'application
::
	$config['url'] = 'http://mon-domaine.com';
	
Changer le titre de l'application
::
	$config['titre_application'] = 'FollowDem';

Modifier l'URL vers un formulaire de contact
::
	$config['emailContact'] = 'http://mon-domaine.com/nous-contacter';
	
Définir les langues disponibles (complétez le array en suivant la logique ci-dessous)
::
	$config['langue_dispo'] = array('fr_FR'=>'fr','us_US'=>'us');

Définir une langue par défaut
::
	$config['langue_defaut'] = 'fr';

Choisir un fuseau horaire
::
	$config['fuseau'] = 'Europe/Paris';

Modifier l'encodage de l'application par défaut
::
	$config['encodage'] = 'UTF-8';

Changer l'encodage de la date de sortie
::
	$config['datesortie'] = '%a %e %b %Y - %H:%M';

Définir la durée en jours minimale de non mise-à-jour des données (un objet est désactivé si il n'a pas reçu de données pendant cette durée)
::
	$config['date_data_valide'] = 150;

Changer la période minimale de suivi d'un objet (en jours)
::
	$config['periode_min'] = 15; 

Changer la période maximale de suivi d'un objet
::
	$config['periode_max'] = 360;
	
Modifier les périodes possibles pour le suivi d'un objet (affiché sous forme de liste déroulante)
::
	$config['periode_valeurs'] = array(3,15,30,60,90,120,150,180,210,240,270,300,330,360);

Sélectionner un séparateur pour le chemin du répertoire de l'application
::
	$config['system_separateur'] = '/';

Modifier le répertoire de l'application
::
	$config['rep_appli'] = '/var/www/followdem';
	
Définir le séparateur dans les fichiers CSV
::
	$config['csv_separateur'] = ',';

Définir le paramètre d'exclusion de caractères spéciaux
::
	$config['csv_enclosure'] = '"';

Modifier le nom du fichier CSV contenant les données à importer dans la BDD
::
	$config['csv_name'] = 'tracked_objects.csv';

Modifier le répertoire qui contient ce fichier CSV
::
	$config['csv_repertoire'] = 'csv';

Définir les colonnes du fichier CSV que vous voulez utiliser
::
	$config['csv_colonne'] = array('id'=>0,'nom'=>1,'date'=>2,'heure'=>3,'latitude'=>5,'longitude'=>6,'temperature'=>11,'nb_satellites'=>7,'altitude'=>9);

Affecter l'Id d'un objet à un nom d'objet
::
	$config['csv_nom_tracked_objects'] = array();

Changer l'email de réception des erreurs de traitement des fichiers CSV
::
	$config['csv_email_error_nom'] = array('monPrenom'=>'exemple@domaine.com');

Choisir si la transmission d'email d'erreur lors de l'import est autorisée
::
	$config['csv_email_error'] = false;

Récupérer des propriétés supplémentaires dans le CSV
::
	$config['csv_colonne_objects_features'] = array();

Modifier le format de date du fichier CSV
::
	$config['csv_date_format'] = 'Y-m-d';
	
Modifier le format de l'heure du fichier CSV
::
	$config['csv_heure_format'] = 'H:i:s';	
	
Changer les restrictions d'import de certaines données dans le fichier CSV
::
	$config['csv_condition'] = array(array(5,'>0'),array(6,'>0'),array(9,'>1000'),array(9,'<4102'));
	$config['csv_condition_type'] = array(5=>'numeric',6=>'numeric',9=>'numeric');

Modifier les paramètres de connexion à la base de données
::
	$config['db_host'] 		= 	'localhost';
	$config['db_name'] 		= 	'dbname';
	$config['db_user'] 		= 	'dbuser';
	$config['db_password'] 	= 	'monpassachanger';
	$config['db_prefixe'] 	= 	'';
	$config['db_type'] 		= 	'mysql';
	$config['db_encodage']  = 	'UTF8';
	
Modifier les paramètres d'envoi d'email
::
	$config['email_smtp'] 			= 	'smtp.domaine.com';
	$config['email_user'] 			= 	'exemple@domaine.com';
	$config['email_password'] 		= 	'monpassachanger';
	$config['email_port'] 			= 	465;
	$config['email_SMTPAuth'] 		= 	true; //true - false
	$config['email_SMTPSecure'] 	= 	'ssl'; //ssl - tls
	$config['email_Charset'] 		= 	'UTF-8';
	$config['email_From'] 			= 	'exemple@domaine.com';
	$config['email_FromName'] 		= 	'FollowDem';
	
Choisir si le debug dans Smarty est autorisé
::
	$config['smarty_debugging'] = false;
	
Choisir si le cache serveur dans Smarty est autorisé
::
	$config['smarty_caching'] = true;

Définir la durée de vie du cache serveur Smarty
::
	$config['smarty_cache_lifetime'] = 120;

Paramétrer les fonds de carte utilisés par l'application. 

Si vous utilisez les fonds de cartes IGN, pensez à remplacer la valeur de ``maCleIgn`` dans ``url``.

Renseignez aussi cette cle IGN dans le paramètre ``cleIgn`` du fichier ``/config/carto.php``
::
	$config['leaflet_fonds_carte'] = array(
			"IGNCARTE"=>array(
				'name'=>'Carte IGN',
				'url'=>'http://gpp3-wxs.ign.fr/maCleIgn/geoportail/wmts?LAYER=GEOGRAPHICALGRIDSYSTEMS.MAPS.SCAN-EXPRESS.STANDARD&EXCEPTIONS=text/xml&FORMAT=image/jpeg&SERVICE=WMTS&VERSION=1.0.0&REQUEST=GetTile&STYLE=normal&TILEMATRIXSET=PM&TILEMATRIX={z}&TILEROW={y}&TILECOL={x}',
				'attribution'=>'IGN',
				'maxZoom'=>17,
				'subdomains'=>''
			),
			"IGNPHOTO"=>array(
				'name'=>'Photo aérienne IGN',
				'url'=>'http://gpp3-wxs.ign.fr/maCleIgn/geoportail/wmts?LAYER=ORTHOIMAGERY.ORTHOPHOTOS&EXCEPTIONS=text/xml&FORMAT=image/jpeg&SERVICE=WMTS&VERSION=1.0.0&REQUEST=GetTile&STYLE=normal&TILEMATRIXSET=PM&TILEMATRIX={z}&TILEROW={y}&TILECOL={x}',
				'attribution'=>'IGN',
				'maxZoom'=>19,
				'subdomains'=>''
			),
			"IGNCARTEDET"=>array(
				'name'=>'Carte détaillée IGN',
				'url'=>'http://gpp3-wxs.ign.fr/maCleIgn/geoportail/wmts?LAYER=GEOGRAPHICALGRIDSYSTEMS.MAPS&EXCEPTIONS=text/xml&FORMAT=image/jpeg&SERVICE=WMTS&VERSION=1.0.0&REQUEST=GetTile&STYLE=normal&TILEMATRIXSET=PM&TILEMATRIX={z}&TILEROW={y}&TILECOL={x}',
				'attribution'=>'IGN',
				'maxZoom'=>17,
				'subdomains'=>''
			),
			"OSM"=>array(
				'name'=>'OpenStreetMap',
				'url'=>'http://{s}.mqcdn.com/tiles/1.0.0/osm/{z}/{x}/{y}.png',
				'attribution'=>'Tiles courtesy of <a href="http://www.mapquest.com/" target="_blank">MapQuest</a>. Map data (c) <a href="http://www.openstreetmap.org/" target="_blank">OpenStreetMap</a> contributors, CC-BY-SA.',
				'maxZoom'=>19,
				'subdomains'=>array("otile1", "otile2", "otile3", "otile4")
			)
		);

Choisir le fond de carte par défaut sur l'application
::
	$config['leaflet_fonds_carte_defaut'] = "OSM";

Changer les pictogrammes utilisés par Leaflet
::
	$config['leaflet_pictos'] = array('position'=>
		array(
			'iconUrl'=>'images/marker-icon.png',
			'iconRetinaUrl'=>'images/marker-icon-2x',
			'iconSize'=>array(25, 41),
			'iconAnchor'=>array(13, 20),
			'popupAnchor'=>array(0, 0),
			'shadowUrl'=>'images/marker-shadow.png',
			'shadowRetinaUrl'=>'images/marker-shadow.png',
			'shadowSize'=>array(41, 41),
			'shadowAnchor'=>array(13, 20)
		)
	);
	
Choisir la position de centrage initial sur la carte
::
	$config['leaflet_centrage_initiale'] = array('44.845159','6.310043');
	
Définir le zoom initial sur la carte
::
	$config['leaflet_zoom_initial'] = 11;

Définir le zoom maximal sur la carte
::
	$config['leaflet_zoom_max'] = 17;

Définir la position des icônes de zoom sur la carte
::
	$config['leaflet_position_zoom'] = 'topright';

Choisir si le fond Google Maps sur la carte est autorisé
::
	$config['leaflet_gmap'] = false;

Choisir un style par défaut pour les tracés
::
	$config['lefleat_style_trace'] = array('color'=>"#000","fillColor"=>"#FFF","Opacity"=>1,"fillOpacity"=>1,"weight"=>3);
	
Choisir un style par défaut pour les flèches de direction
::
	$config['lefleat_style_direction'] = array('color'=>"#7F2B7F","Opacity"=>1,"weight"=>3);

Modifier la distance d'affichage des flèches directionnelles sur les tracés
::
	$config['lefleat_repeat_direction'] = '50';
	
Choisir un style par défaut des derniers points de suivi des objets
::
	$config['lefleat_style_point_defaut'] = array('color'=>"#A60000","fillColor"=>"#f03","Opacity"=>1,"fillOpacity"=>0.9,"weight"=>5);

Modifier le style des derniers points en fonction des paramètres contenus dans la base de données
::
	$config['lefleat_style_point_surcharge'] = array('color'=>"couleurD","fillColor"=>"couleurG","Opacity"=>1,"fillOpacity"=>0.9,"weight"=>5);

Paramétrer le suivi statistique de l'application (Google Analytics dans cet exemple avec ID à remplacer par le votre)	
::
	$config['active_tracking_stats'] = 'true';
	$config['tracking_stats'] = "
	<script type='text/javascript'>
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'ID_GOOGLE_ANALYTICS_A_MODIFIER']);
		_gaq.push(['_trackPageview']);
		(function() {
			var ga = document.createElement('script');
			ga.type = 'text/javascript';
			ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>";
	
Choisir si la récupération de la couleur dans le nom de l'objet est autorisée
::
	$config['recupe_couleur_name_tracked_objects'] = true;

Choisir si l'affichage des messages d'erreurs et des exceptions est autorisé
::	
	$config['debug']=true;	

Choisir si l'enregistrement des logs dans la base de données est autorisé
::
	$config['log']=false;

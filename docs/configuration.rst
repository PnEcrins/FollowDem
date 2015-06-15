=============
CONFIGURATION
=============

Principe de l'application
=========================

L'application utilise des données transmises par des objets équipés d'un GPS.
Le traitement de ces données s'effectue en plusieurs étapes.
Tout d'abord, les GPS envoient leurs positions aux satellites.
Ensuite, les satellites envoient les données en pièce jointe sur une boîte mail, ces fichiers sont des fichiers txt.
Et enfin, l'application effectue un traitement qui consiste à récupérer ces fichiers txt puis les transformer en fichiers csv.

Le fichier csv est constitué de plusieurs colonnes : 
Id de l'objet.
Nom de l'objet.
Date de l'envoi des données au satellite.
Heure de l'envoi des données au satellite.
TTF (pas utilisé)
Latitude.
Longitude.
Nombre de satellites.
3D ou 2D. (si c'est on 3D on a l'altitude)
Altitude de l'objet.
H-DOP. (permet de connaître la fiabilité de la position)
Température.
X (pas utilisé)
Y (pas utilisé)


Configurer l'application
========================

Rendez vous dans le fichier ``config.php``, c'est ce fichier qui est la base de la configuration de l'application.
Modifier nom de domaine de l'application

::
	$config['url'] = 'http://mon-domaine.com';
	
Changer le titre de l'entête sur l'application

::
	$config['titre_application'] = 'FollowDem';

Modifier l'url vers un formulaire de contact

::
	$config['emailContact'] = 'http://mon-domaine.com/nous-contacter';
	
Proposer plusieurs langues disponible (complétez le array en suivant la logique ci-dessous)

::
	$config['langue_dispo'] = array('fr_FR'=>'fr','us_US'=>'us');

Définir une langue par défaut

::
	$config['langue_defaut'] = 'fr';

Choisir un fuseau horaire

::
	$config['fuseau'] = 'Europe/Paris';

Modifier l'encodage par défaut

::
	$config['encodage'] = 'UTF-8';

Changer l'encodage de la date de sortie

::
	$config['datesortie'] = '%a %e %b %Y - %H:%M';

Définir la date minimale de non mise-à-jour des données (les données sont valides si elles ne sont pas plus anciennes que la valeur donnée)

::
	$config['date_data_valide'] = 150;

Changer la période minimale de suivi d'un objet

::
	$config['periode_min'] = 15; 

Changer la période maximale de suivi d'un objet

::
	$config['periode_max'] = 360;
	
Modifier les périodes possibles pour le suivi d'un objet

::
	$config['periode_valeurs'] = array(3,15,30,60,90,120,150,180,210,240,270,300,330,360);

Sélectionner un séparateur pour le chemin du répertoire de l'application

::
	$config['system_separateur'] = '/';

Modifier le répertoire de l'application

::
	$config['rep_appli'] = '/var/www/followdem';
	
Définir le séparateur dans les fichiers csv

::
	$config['csv_separateur'] = ',';

Définir le paramètre d'exclusion de caractères spéciaux

::
	$config['csv_enclosure'] = '"';

Modifier le nom du fichier csv de l'application

::
	$config['csv_name'] = 'tracked_objects.csv';

Modifier le répertoire qui contient le fichier csv

::
	$config['csv_repertoire'] = 'csv';

Définir les colonnes du fichier csv que vous voulez utiliser

::
	$config['csv_colonne'] = array('id'=>0,'nom'=>1,'date'=>2,'heure'=>3,'latitude'=>5,'longitude'=>6,'temperature'=>11,'nb_satellites'=>7,'altitude'=>9);

Affecter l'Id d'un objet à un nom d'objet

::
	$config['csv_nom_tracked_objects'] = array();

Changer l'email de réception des erreurs de traitement des fichiers csv

::
	$config['csv_email_error_nom'] = array('monPrenom'=>'exemple@domaine.com');

Choisir si la transmission d'email d'erreur lors de l'import est autorisée

::
	$config['csv_email_error'] = false;

Récupérer des propriétés supplémentaires dans le csv
	
::
	$config['csv_colonne_objects_features'] = array();

Modifier le format de date du fichier csv

::
	$config['csv_date_format'] = 'Y-m-d';
	
Modifier le format de l'heure du fichier csv
	
::
	$config['csv_heure_format'] = 'H:i:s';	
	
Changer la restriction d'import de certaines données dans le fichier csv

::
	$config['csv_condition'] = array(array(5,'>0'),array(6,'>0'),array(9,'>1000'),array(9,'<4102'));
	$config['csv_condition_type'] = array(5=>'numeric',6=>'numeric',9=>'numeric');

Modifier les paramètres de la base de données

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

Paramétrer les fonds de cartes utilisés par l'application, si vous utilisez les fonds de cartes IGN, pensez à remplacer la valeur de maCleIgn dans 'url'

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
	
Choisir la position de centrale initial sur la carte

::
	$config['leaflet_centrage_initiale'] = array('44.845159','6.310043');
	
Modifier le zoom initial sur la carte

::
	$config['leaflet_zoom_initial'] = 11;

Modifier le zoom maximal sur la carte

::
	$config['leaflet_zoom_max'] = 17;

Changer la position des icônes de zoom sur la carte

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

Paramétrer le suivi statistique de l'application	
	
::
	$config['active_tracking_stats'] = 'true';
	$config['tracking_stats'] = "
	<script type='text/javascript'>
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-7988554-6']);
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
<?php
/**
*	Classe API
* 	Classe permettant l'interface l'IHM... renvoi des donn�es pour l'affichage ou le traitement
*	@author Fabien Selles
*	@copyright Parc National des �crins
*
*/

class api
{


	public static $smarty;

	/**
	* 	Smarty - Charge et renvoi l'instance de smarty
	*
	* 	@access  public
	* 	@return  tracked_objects
	* 	@param
	*/
	public static function smarty()
	{
		if(is_null(static::$smarty))
		{
			static::$smarty = new Smarty;
			static::$smarty->debugging = config::get('smarty_debugging');
			static::$smarty->caching = config::get('smarty_caching');
			static::$smarty->cache_lifetime = config::get('smarty_cache_lifetime');


			/*if(config::get('smarty_caching')){static::$smarty->setCaching(Smarty::CACHING_LIFETIME_CURRENT);}
			static::$smarty->setCacheLifetime(300);	*/
		}
		return static::$smarty;
	}


	/**
	* 	leaflet_ini - Itnitialisation de leaflet_1
	*
	* 	@access  public
	* 	@return  string
	* 	@param $object = animals
	*/
	public static function leaflet_ini($objets)
	{
		$leaflet_ini = '<script type="text/javascript">';

		$tmp_control_map = array();

		if(config::get('leaflet_gmap'))
		{
			$leaflet_ini .='var GoogleLayer = new L.Google();';
			$tmp_control_map[traduction::t('Google Satellite',1)] = 'GoogleLayer';
		}
		$leaflet_ini .='latlng = new L.LatLng('.config::get('leaflet_centrage_initiale',0).','.config::get('leaflet_centrage_initiale',1).');';

		/* Gestion des pictogrammes utilis�s */
		foreach(config::get('leaflet_pictos') as $nomvar=>$params)
		{
			$leaflet_ini .= 'var '.$nomvar.' = L.icon({';
			foreach($params as $nom=>$value)
			{
				if (is_array($value))
					$leaflet_ini .= $nom.':'.json_encode($value).',';
				else
					$leaflet_ini .= $nom.':\''.$value.'\',';
			}

			$leaflet_ini .= '});';
		}

		/*Gestion des fonds de carte disponibles*/
		foreach(config::get('leaflet_fonds_carte') as $nom=>$param)
		{
			$leaflet_ini .= 'var '.$nom.' = new L.TileLayer(\''.$param['url'].'\', {maxZoom: '.$param['maxZoom'].', attribution: \''.$param['attribution'].'\', subdomains: '.json_encode($param['subdomains']).'});';
			$tmp_control_map[$param['name']] = $nom;
		}

		$leaflet_ini .='var map = new L.Map(\'map\', {zoomControl: false, center: latlng, maxZoom:'.config::get('leaflet_zoom_max').', zoom: '.config::get('leaflet_zoom_initial').', layers: ['.config::get('leaflet_fonds_carte_defaut').']});';
		$leaflet_ini .='map.addControl(L.control.zoom({position: \''.config::get('leaflet_position_zoom').'\'}) );';
		$leaflet_ini .='map.addControl(L.control.scale({position: \'bottomright\'}));';

		/*$leaflet_ini .='var circle = L.circle([44.762038,6.187642], 42, {
								color: \'red\',
								fillColor: \'#f03\',
								fillOpacity: 0.5
							}).addTo(map);';*/


		/* Style par defaut pour les trac�s */
		$leaflet_ini .= 'var styleTrace = '.json_encode(config::get('lefleat_style_trace')).';';


		/*Cr�ation d'un layer pour les direction (fl�ches) sur le Layer Ligne */

		$leaflet_ini .='var geojsonLayerLineGroup = new L.layerGroup();
		geojsonLayerLineGroup.addTo(map);
		';

		/*Cr�ation d'un Layer pour les donn�es GeoJson Line */
		$leaflet_ini .='
		var geojsonLayerLine = new L.GeoJSON(null, {
			style:styleTrace,
			onEachFeature: function (feature, layer) {

				if (feature.properties) {
					/*var popupString = \'<div class="popup">\';
					for (var k in feature.properties) {
						var v = feature.properties[k];
						popupString += v + \'<br />\';
					}
					popupString += \'</div>\';
					layer.bindPopup(popupString, {
						maxHeight: 200
					});*/
				}
				/*Formatage Lat/Long*/
				var latlong = [];
				for (var k in feature.geometry["coordinates"])
				{
					var lat = feature.geometry["coordinates"][k][0];
					var long = feature.geometry["coordinates"][k][1];
					latlong[k] = [long,lat];
				}

				/*Initialisation du groupe de layers*/
				geojsonLayerLineGroup.clearLayers();

				/*Il peut arriver que le Geojson soit vide ou ne contienne que une coordonn�e*/
				if(latlong.length > 1)
				{
					var fleche = new L.polylineDecorator( latlong, {
						patterns: [
							{offset: 0, repeat: \''.config::get('lefleat_repeat_direction').'px\', symbol: new L.Symbol.ArrowHead({pixelSize: 10, polygon: false,pathOptions: '.json_encode(config::get('lefleat_style_direction')).'})}
						]
					}).addTo(map);
					geojsonLayerLineGroup.addLayer(fleche);
				}

				geojsonLayerLineGroup.addLayer(geojsonLayerLine);

			}

		});
		/*map.addLayer(geojsonLayerLine);*/';

		/*Cr�ation d'un Layer pour les donn�es GeoJson Points */
		$leaflet_ini .='var geojsonLayerPoint = new L.GeoJSON(null, {
			style:styleTrace,
			pointToLayer: function (feature, latlng) {
				if(feature.properties[\'first\']==0){
					return L.circleMarker(latlng, {radius:5});}
				else {
					return L.circleMarker(latlng, {radius:10});}
			},
			onEachFeature: function (feature, layer) {
				if (feature.properties) {
					var popupString = \'<p>\';
					for (var k in feature.properties) {
						if (k != \'first\'){
							var v = feature.properties[k];
							popupString += \'<strong>\' + k + \'</strong> : \' + v + \'<br />\';
						}
					}
					popupString += \'</p>\';
					layer.bindPopup(popupString);
					// {maxHeight: 250}
				}
			}
		});
		map.addLayer(geojsonLayerPoint);';


		/*Cr�ation d'un Layer pour les donn�es GeoJson Point Derniers emplacement */
		$leaflet_ini .='var geojsonLayerPointLast = new L.GeoJSON(null);
		map.addLayer(geojsonLayerPointLast);
		geojsonLayerPointLast.bringToFront();';

		/*Affichage du choix des layers disponibles - Fond de carte et layer des donn�es*/
		$leaflet_ini .='map.addControl(new L.Control.Layers({';
		foreach($tmp_control_map as $nom=>$value)
			$leaflet_ini .= '\''.$nom.'\':'.$value.',';
		$leaflet_ini .='},{\''.traduction::t('Derniers points',1).' \':geojsonLayerPointLast,\''.traduction::t('Traces',1).' \':geojsonLayerLineGroup,\''.traduction::t('Points',1).' \':geojsonLayerPoint}));';




		/* Traitement des objets - markers � afficher */
		if(count($objets) > 0) {
			$leaflet_ini .='var markers = {};';
			foreach($objets as $tracked_objects)
			{
				/*On d�fini les styles pour le point de la derni�re position (cercle)*/


				if (count(config::get('lefleat_style_point_surcharge')) > 0 && $tracked_objects->get_object_feature(config::get('lefleat_style_point_surcharge','color')))
				{
					$tmp_style = 'var style'.$tracked_objects->getIdAnimal(). '='.json_encode(config::get('lefleat_style_point_surcharge')).';';

					$tmp_style = str_replace(config::get('lefleat_style_point_surcharge','color'),$tracked_objects->get_object_feature(config::get('lefleat_style_point_surcharge','color')),$tmp_style);
					$tmp_style = str_replace(config::get('lefleat_style_point_surcharge','fillColor'),$tracked_objects->get_object_feature(config::get('lefleat_style_point_surcharge','fillColor')),$tmp_style);
					$leaflet_ini .= $tmp_style;

					/*'var style'.$tracked_objects->get_id(). '= {
						color: \''.$tracked_objects->get_object_feature(config::get('lefleat_style_point_surcharge','color')).'\',
						fillColor: \''.$tracked_objects->get_object_feature(config::get('lefleat_style_point_surcharge','fillColor')).'\',';
						foreach(config::get('lefleat_style_point_defaut')) as $clef=>$valeur)
						{
							if ($clef !='color' && $clef !='fillColor')
								$leaflet_ini .= $clef.':\''.$valeur.'\',';
						}

					$leaflet_ini .=	'};';*/
				}
				else
				{
					$leaflet_ini .= 'var style'.$tracked_objects->getIdAnimal(). '='.json_encode(config::get('lefleat_style_point_defaut')).';';
				}
				if(count($tracked_objects->getGpsData()) > 0)
				{


					foreach($tracked_objects->getGpsData() as $gps_data)
					{
						//$leaflet_ini .= 'new L.LatLng('.$gps_data->get_latitude().','.$gps_data->get_longitude().');';
 						$leaflet_ini .= 'markers['.$tracked_objects->getIdAnimal().'] = L.circleMarker(['.$gps_data->getLatitude().','.$gps_data->getLongitude().'], style'.$tracked_objects->getIdAnimal().').addTo(geojsonLayerPointLast);';
						$leaflet_ini .= 'markers['.$tracked_objects->getIdAnimal().'].bindPopup("<p><strong>'.$tracked_objects->getName().'</strong><br />'.$gps_data->getGpsDate().'<br /><a id=\"voirparcours'.$tracked_objects->getIdAnimal().'\" href=\"#\" onClick=\"active_parcours(false);\"><i class=\"glyphicon glyphicon-map-marker\"></i> Voir le parcours</a></p>");';
						$leaflet_ini .= 'markers['.$tracked_objects->getIdAnimal().'].on(\'click\', function (d) {
							  active_tracked_objects('.$tracked_objects->getIdAnimal().');
						});';

						/*
						$leaflet_ini .= 'var marker'.$gps_data->get_id().' = L.Marker(['.$gps_data->get_latitude().','.$gps_data->get_longitude().'],{icon: position}).addTo(map);';
						$leaflet_ini .= 'map.addLayer(marker'.$gps_data->get_id().');';
						$leaflet_ini .= 'marker'.$gps_data->get_id().'.bindPopup("'.$tracked_objects->get_nom().'<br />'.$gps_data->get_dateheure().'");';*/
					}
				}
			}
		}

		//$leaflet_ini .='var markekettest = L.marker(['.config::get('leaflet_centrage_initiale',0).','.config::get('leaflet_centrage_initiale',1).'],{icon:position}).addTo(map);';
		//$leaflet_ini .='markekettest.bindPopup("<p>TEST</p>");';
		$leaflet_ini .='</script>';
		return $leaflet_ini;

		/*
		var marker = new L.Marker(latlng,{icon: myIcon});
		map.addLayer(marker);


		marker.bindPopup("<p>Parc National des �crins</p>");*/

	}


	/**
	* 	send_mail - envoi d'un email en smtp
	*
	* 	@access  public
	* 	@return  string
	* 	@param
	*/
	public static function send_email($to,$subjet,$body)
	{
		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->Host = config::get('email_smtp');
		$mail->Port = config::get('email_port');
		$mail->SMTPAuth = config::get('email_SMTPAuth');
		$mail->CharSet = config::get('email_Charset');
		$mail->SMTPSecure = config::get('email_SMTPSecure');
		$mail->Username = config::get('email_user');
		$mail->Password = config::get('email_password');
		$mail->setFrom(config::get('email_From'), config::get('email_FromName'));
		$mail->Subject = $subjet;
		$mail->msgHTML($body);
		foreach($to as $nom=>$email)
			$mail->addAddress($email,$nom);
		if (!$mail->send()) {
			echo $mail->ErrorInfo;
			return false;
		} else {
			return true;
		}
	}

}
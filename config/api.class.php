<?php
/**
*	Classe API 
* 	Classe permettant l'interface l'IHM... renvoi des données pour l'affichage ou le traitement
*	@author Fabien Selles
*	@copyright Parc National des écrins
*	
*/

class api
{	
	
	
	public static $smarty;
	
	/**
	* 	Smarty - Charge et renvoi l'instance de smarty
	*
	* 	@access  public
	* 	@return  objet
	* 	@param
	*/
	public static function smarty()
	{
		if(is_null(static::$smarty))
			static::$smarty = new Smarty;
		return static::$smarty;
	}
	
	
	/**
	* 	leaflet_ini - Itnitialisation de leaflet
	*
	* 	@access  public
	* 	@return  string
	* 	@param
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
		
		foreach(config::get('leaflet_fonds_carte') as $nom=>$param)
		{
			$leaflet_ini .= 'var '.$nom.' = new L.TileLayer(\''.$param['url'].'\', {maxZoom: '.$param['maxZoom'].', attribution: \''.$param['attribution'].'\', subdomains: '.json_encode($param['subdomains']).'});';
			$tmp_control_map[$param['name']] = $nom;
		}
		
		$leaflet_ini .='var map = new L.Map(\'map\', {zoomControl: false, center: latlng, zoom: '.config::get('leaflet_zoom_initial').', layers: ['.config::get('leaflet_fonds_carte_defaut').']});';
		$leaflet_ini .='map.addControl(new L.Control.Layers({';
		foreach($tmp_control_map as $nom=>$value)
			$leaflet_ini .= '\''.$nom.'\':'.$value.',';
		$leaflet_ini .='}));';
		$leaflet_ini .='map.addControl(L.control.zoom({position: \''.config::get('leaflet_position_zoom').'\'}) );';
		
		
		/* Traitement des objets - markers à afficher */
		if(count($objets) > 0) {
			foreach($objets as $tracked_objects)
			{
				if(count($tracked_objects->get_gps_data()) > 0)
				{
					foreach($tracked_objects->get_gps_data() as $donnee)
					{
						//$leaflet_ini .= 'new L.LatLng('.$donnee->get_latitude().','.$donnee->get_longitude().');';
						$leaflet_ini .= 'var circle'.$donnee->get_id().' = L.circle(['.$donnee->get_latitude().','','.$donnee->get_longitude().'], 40, {
								color: \'red\',
								fillColor: \'#f03\',
								fillOpacity: 0.5
							}).addTo(map);';
						/*
						$leaflet_ini .= 'var marker'.$donnee->get_id().' = L.Marker(['.$donnee->get_latitude().','.$donnee->get_longitude().'],{icon: position}).addTo(map);';
						$leaflet_ini .= 'map.addLayer(marker'.$donnee->get_id().');';
						$leaflet_ini .= 'marker'.$donnee->get_id().'.bindPopup("'.$tracked_objects->get_nom().'<br />'.$donnee->get_dateheure().'");';*/
					}
				}
			}
		}
		$leaflet_ini .='</script>';
		return $leaflet_ini;
		
		/*
		var marker = new L.Marker(latlng,{icon: myIcon});
		map.addLayer(marker);
		
	
		marker.bindPopup("<p>Parc National des écrins</p>");*/
	
	}
	
}
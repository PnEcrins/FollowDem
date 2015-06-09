<?php
	/**
	*	Configuration des élements de cartographie
	*	Configuration libre de leaflet
	*	@author Fabien Selles
	*	@copyright Parc National des Écrins
	*
	*/
?>
<script type="text/javascript">
	
		/**
		*	Les fonds de cartes
		*	Renseigner la variable cleIgn
		*
		*/
		var cleIgn = 'maCleIgn';
		var IGNUrl = 'http://gpp3-wxs.ign.fr/'+cleIgn+'/geoportail/wmts?LAYER=GEOGRAPHICALGRIDSYSTEMS.MAPS&EXCEPTIONS=text/xml&FORMAT=image/jpeg&SERVICE=WMTS&VERSION=1.0.0&REQUEST=GetTile&STYLE=normal&TILEMATRIXSET=PM&TILEMATRIX={z}&TILEROW={y}&TILECOL={x}',
			IGNAttribution = 'IGN - Top 25',
			IGN = new L.TileLayer(IGNUrl, {maxZoom: 18, attribution: IGNAttribution}),
			latlng = new L.LatLng(44.845159,6.310043);
		
		var cloudmadeUrl = 'http://{s}.tile.cloudmade.com/d4fc77ea4a63471cab2423e66626cbb6/997/256/{z}/{x}/{y}.png',
			cloudmadeAttribution = 'Map data &copy; 2011 OpenStreetMap contributors, Imagery &copy; 2011 CloudMade',
			cloudmade = new L.TileLayer(cloudmadeUrl, {maxZoom: 18, attribution: cloudmadeAttribution}),
			latlng = new L.LatLng(44.845159,6.310043);
		
		var MapboxUrl = 'http://{s}.tiles.mapbox.com/v3/examples.map-4l7djmvo/{z}/{x}/{y}.png',
			MapboxAttribution = 'Mapbox relief',
			Mapbox = new L.TileLayer(MapboxUrl, {maxZoom: 19, attribution: MapboxAttribution}),
			latlng = new L.LatLng(44.845159,6.310043);
		
		var GoogleLayer = new L.Google();
		
		var mapquestOSM = new L.TileLayer("http://{s}.mqcdn.com/tiles/1.0.0/osm/{z}/{x}/{y}.png", {
		maxZoom: 19,
		subdomains: ["otile1", "otile2", "otile3", "otile4"],
		attribution: 'Tiles courtesy of <a href="http://www.mapquest.com/" target="_blank">MapQuest</a>. Map data (c) <a href="http://www.openstreetmap.org/" target="_blank">OpenStreetMap</a> contributors, CC-BY-SA.'
		});

		var mapquestOAM = new L.TileLayer("http://{s}.mqcdn.com/tiles/1.0.0/sat/{z}/{x}/{y}.jpg", {
		maxZoom: 19,
		subdomains: ["oatile1", "oatile2", "oatile3", "oatile4"],
		attribution: 'Tiles courtesy of <a href="http://www.mapquest.com/" target="_blank">MapQuest</a>. Map data (c) <a href="http://www.openstreetmap.org/" target="_blank">OpenStreetMap</a> contributors, CC-BY-SA.'
		});
		
}
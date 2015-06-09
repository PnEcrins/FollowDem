/**
* IHM
*
**/

	/* On ferme la carte et on met la sidebar en full screen sur "mobile" */
	$(document).ready(function() {
		/*$('[rel=tooltip]').tooltip();*/
		//alert(document.body.clientWidth);
		if (document.body.clientWidth <= 992) {
			/*$('#sidebar').toggle();
			*/
			//$('#map').toggleClass('col-sm-8 col-lg-8 col-sm-12 col-lg-12');
			$('a.toggle i').toggleClass('icon-chevron-left icon-chevron-right');
			$('#map').toggle();
			//$('#sidebar').toggleClass('col-sm-4 col-lg-4 col-sm-12 col-lg-12');
		};
	});
	
/*
	$(window).bind( 'orientationchange', function(e){
		if ($.event.special.orientationchange.orientation() == "portrait") {
			alert('portrait');
		} else {
			alert('landscape');
		}
	});*/
	
	
	$(document).ajaxSend(function(event, request, settings) {
		$('#loading').show();
	});

	$(document).ajaxComplete(function(event, request, settings) {
		$('#loading').hide();
	});
	
	
	map.whenReady(function() {$('#loading').hide();});
	
	
	$(window).resize(function() {
		$('.tt-dropdown-menu').css('max-height', $('#container').height()-$('.navbar').height()-20);
	});

	$('a.toggle').click(function() {
		oc_sidebar();
	});
	
	/* Open/Close sidebar */
	function oc_sidebar()
	{
		$('a.toggle i').toggleClass('icon-chevron-left icon-chevron-right');
		$('#map').toggleClass('col-xs-12 col-sm-12 col-md-7 col-lg-8 col-xs-12 col-sm-12 col-md-12 col-lg-12'); 
		//col-sd-12 col-md-7 col-sm-8 col-lg-8 col-sd-12 col-md-12 col-sm-12 col-lg-12');
		if (document.body.clientWidth < 992) {
			//$('#sidebar').toggleClass('col-sm-4 col-lg-4 col-sm-12 col-lg-12');
			$('#map').toggle();	
		}
		else
		{
			//on affiche la carte si l'écran est redim entre temps
			if($('#map').css('display') == 'none')
			{
				$('#map').show();	
				$('#sidebar').toggleClass('col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-12 col-sm-12 col-md-7 col-lg-8');
			}
		}
		$('#sidebar').toggle();
		map.invalidateSize();
		return false;
	}
	/*$(document).ajaxStop(function() {
		$('#loading').hide();
	});*/


/**
* Interaction liste d'objet et Map
*
*
*/
	/*identifiant actuel de l'objet*/
	var id = 0;
	
	/*Periode actuelle d'analyse*/
	var periode = 0;
	
	/*Clique sur la liste des objets... Affiche la popup */
	$('.tracked_objects').click(function(){
		id = $(this).attr('id');
		active_tracked_objects(id);
		active_parcours();
	});
	
	/*Active le parcours selon l'ID de l'objet et la période */
	function active_parcours(closeSide)
	{
		//closeSide = typeof closeSide !== 'undefined' ? closeSide : true;
		//map.setView(latlng,12);
	
		$('#loading').show();
		/*On ferme la sidebar si sur mobile et on affiche la carte*/
		if (document.body.clientWidth <= 992) {
			oc_sidebar();
		}
		/*
		if (document.body.clientWidth <= 1000 && closeSide==true) {
			$('#map').toggle();
			$('#sidebar').toggle();
			$('a.toggle i').toggleClass('icon-chevron-left icon-chevron-right');
			map.invalidateSize();
		};*/
		
		periode = $("#periode").val();
		markers[id].openPopup();
		
		var latlonmarker = markers[id].getLatLng();
		
		
		/*On récupère les tracés et les points lié à la période*/
		$.ajaxSetup({async: false});
		get_geoJson(id,'Line');
		get_geoJson(id,'Point');
		$.ajaxSetup({async: true});
		
		//map.fitBounds(geojsonLayerLine.getBounds());
		map.setView(latlonmarker,14);
		
		//var latlon = markers[id].getLatLng(); 
		//map.panTo(latlon);
		//map.invalidateSize();
		
		
		$('#voirparcours'+id).hide();

		return false;
	}

	
	/* Active un objet dans la liste */
	function active_tracked_objects(id_tracked_objects)
	{
		 id = id_tracked_objects;
		 $('.tracked_objects').removeClass('select_tracked_objects');
		 $('#'+id).addClass('select_tracked_objects');
	}
	
	/*Gestion modal initialisation contenu*/
	
	$('#modalepage').on('hidden.bs.modal', function (e) {
		$('#modalepage').removeData('bs.modal');
		$(e.target).html('');
		//$(e.target).removeData('bs.modal');
	});
	
	$('#modalepage').on('shown.bs.modal', function (e) {
		$('#modalepage').animate({ scrollTop: 0 }, 'slow');
		$(e.target).scrollTop(0);
		$('#modalepage').scrollTop(0);
		//$(document).scrollTop(0);
	});
	
	$("#periode").change(function () {
		active_parcours();
		/*
		periode=$(this).val();
		if(id != 0)
		{
			get_geoJson(id,'Line',periode);
			get_geoJson(id,'Point',periode);
		}*/
	});
/** Fin Interaction liste d'objet et Map */

/**
* Chargement de donnée GeoJson en Ajax
*
*
*/
	
/* id : id de l'objet - type : type de données(Line, Point) - periode : période au format PjourD*/
function get_geoJson(id,type){
	  var jsonGet = $.getJSON('/controler/get_parcours_geojson/id_tracked_objects-' + id + '-type-' + type + '-periode-' + periode, function(data) {
			(eval('geojsonLayer'+type)).clearLayers();
			(eval('geojsonLayer'+type)).addData(data);
			markers[id].bringToFront();
		}) .done(function() {
				$('#loading').hide();
				
			})
			.fail(function() {
				$('#loading').hide();
				$('#error').modal();
			})
			.always(function() {
				/*$('#loading').hide();*/
			});
			
		jsonGet.complete(function() {
			$('#loading').hide();
			markers[id].bringToFront();
			//var latlonmarker = markers[id].getLatLng();
			return true;
			//
			//map.setView(latlonmarker,14)
			//map.invalidateSize();
			//map.panInsideBounds(eval('geojsonLayer'+type).getBounds());
			
			//map.panTo(latlon);
			//map.invalidateSize();
		});
	}
/** Fin Chargement de donnée GeoJson en Ajax */
	

/**
* Leafleat paramètres complémentaires
*
*
*/

	/* 
	Exemple pour charger du MBTiles sur la carte avec leaflet
	Tile - Contours du PNE 
	var boundaries = null;
	boundaries = boundaries || L.tileLayer('images/mbtiles/limitespne/{z}/{x}/{y}.png')
	if (!map.hasLayer(boundaries)) {
		 map.addLayer(boundaries);
		  boundaries.bringToFront();
	}*/

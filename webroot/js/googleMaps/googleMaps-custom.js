$('#map_canvas').gmap().bind('init', function(ev, map) {
	$('#map_canvas').gmap('addMarker', {'position': '57.7973333,12.0502107', 'bounds': true}).click(function() {
		$('#map_canvas').gmap('openInfoWindow', {'content': 'Hello World!'}, this);
	});
});

// We need to bind the map with the "init" event otherwise bounds will be null
$('#map_clustering').gmap({'zoom': 2, 'disableDefaultUI':true}).bind('init', function(evt, map) { 
	var bounds = map.getBounds();
	var southWest = bounds.getSouthWest();
	var northEast = bounds.getNorthEast();
	var lngSpan = northEast.lng() - southWest.lng();
	var latSpan = northEast.lat() - southWest.lat();
	for ( var i = 0; i < 1000; i++ ) {
		var lat = southWest.lat() + latSpan * Math.random();
		var lng = southWest.lng() + lngSpan * Math.random();
		$('#map_clustering').gmap('addMarker', { 
			'position': new google.maps.LatLng(lat, lng) 
		}).click(function() {
			$('#map_clustering').gmap('openInfoWindow', { content : 'Hello world!' }, this);
		});
	}
	$('#map_clustering').gmap('set', 'MarkerClusterer', new MarkerClusterer(map, $(this).gmap('get', 'markers')));
	// To call methods in MarkerClusterer simply call 
	// $('#map_clustering').gmap('get', 'MarkerClusterer').callingSomeMethod();
});


$('#map_html5').gmap().bind('init', function(ev, map) {
	$("[data-gmapping]").each(function(i,el) {
		var data = $(el).data('gmapping');
		$('#map_html5').gmap('addMarker', {'id': data.id, 'tags':data.tags, 'position': new google.maps.LatLng(data.latlng.lat, data.latlng.lng), 'bounds':true }, function(map,marker) {
			$(el).click(function() {
				$(marker).triggerEvent('click');
			});
		}).click(function() {
			$('#map_html5').gmap('openInfoWindow', { 'content': $(el).find('.info-box').text() }, this);
		});
	});	
});



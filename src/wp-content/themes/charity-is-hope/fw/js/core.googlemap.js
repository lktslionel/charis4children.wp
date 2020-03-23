function charity_is_hope_googlemap_init(dom_obj, coords) {
	"use strict";
	if (typeof CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'] == 'undefined') charity_is_hope_googlemap_init_styles();
	CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'].geocoder = '';
	try {
		var id = dom_obj.id;
		CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id] = {
			dom: dom_obj,
			markers: coords.markers,
			geocoder_request: false,
			opt: {
				zoom: coords.zoom,
				center: null,
				scrollwheel: false,
				scaleControl: false,
				disableDefaultUI: false,
				panControl: true,
				zoomControl: true, //zoom
				mapTypeControl: false,
				streetViewControl: false,
				overviewMapControl: false,
				styles: CHARITY_IS_HOPE_STORAGE['googlemap_styles'][coords.style ? coords.style : 'default'],
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}
		};
		
		charity_is_hope_googlemap_create(id);

	} catch (e) {
		
		dcl(CHARITY_IS_HOPE_STORAGE['strings']['googlemap_not_avail']);

	};
}

function charity_is_hope_googlemap_create(id) {
	"use strict";

	// Create map
	CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].map = new google.maps.Map(CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].dom, CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].opt);

	// Add markers
	for (var i in CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].markers)
		CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].markers[i].inited = false;
	charity_is_hope_googlemap_add_markers(id);
	
	// Add resize listener
	jQuery(window).resize(function() {
		if (CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].map)
			CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].map.setCenter(CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].opt.center);
	});
}

function charity_is_hope_googlemap_add_markers(id) {
	"use strict";
	for (var i in CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].markers) {
		
		if (CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].markers[i].inited) continue;
		
		if (CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].markers[i].latlng == '') {
			
			if (CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].geocoder_request!==false) continue;
			
			if (CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'].geocoder == '') CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'].geocoder = new google.maps.Geocoder();
			CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].geocoder_request = i;
			CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'].geocoder.geocode({address: CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].markers[i].address}, function(results, status) {
				"use strict";
				if (status == google.maps.GeocoderStatus.OK) {
					var idx = CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].geocoder_request;
					if (results[0].geometry.location.lat && results[0].geometry.location.lng) {
						CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].markers[idx].latlng = '' + results[0].geometry.location.lat() + ',' + results[0].geometry.location.lng();
					} else {
						CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].markers[idx].latlng = results[0].geometry.location.toString().replace(/\(\)/g, '');
					}
					CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].geocoder_request = false;
					setTimeout(function() { 
						charity_is_hope_googlemap_add_markers(id); 
						}, 200);
				} else
					dcl(CHARITY_IS_HOPE_STORAGE['strings']['geocode_error'] + ' ' + status);
			});
		
		} else {
			
			// Prepare marker object
			var latlngStr = CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].markers[i].latlng.split(',');
			var markerInit = {
				map: CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].map,
				position: new google.maps.LatLng(latlngStr[0], latlngStr[1]),
				clickable: CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].markers[i].description!=''
			};
			if (CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].markers[i].point) markerInit.icon = CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].markers[i].point;
			if (CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].markers[i].title) markerInit.title = CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].markers[i].title;
			CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].markers[i].marker = new google.maps.Marker(markerInit);
			
			// Set Map center
			if (CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].opt.center == null) {
				CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].opt.center = markerInit.position;
				CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].map.setCenter(CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].opt.center);				
			}
			
			// Add description window
			if (CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].markers[i].description!='') {
				CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].markers[i].infowindow = new google.maps.InfoWindow({
					content: CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].markers[i].description
				});
				google.maps.event.addListener(CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].markers[i].marker, "click", function(e) {
					var latlng = e.latLng.toString().replace("(", '').replace(")", "").replace(" ", "");
					for (var i in CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].markers) {
						if (latlng == CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].markers[i].latlng) {
							CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].markers[i].infowindow.open(
								CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].map,
								CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].markers[i].marker
							);
							break;
						}
					}
				});
			}
			
			CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'][id].markers[i].inited = true;
		}
	}
}

function charity_is_hope_googlemap_refresh() {
	"use strict";
	for (id in CHARITY_IS_HOPE_STORAGE['googlemap_init_obj']) {
		charity_is_hope_googlemap_create(id);
	}
}

function charity_is_hope_googlemap_init_styles() {
	// Init Google map
	CHARITY_IS_HOPE_STORAGE['googlemap_init_obj'] = {};
	CHARITY_IS_HOPE_STORAGE['googlemap_styles'] = {
		'default': []
	};
	if (window.charity_is_hope_theme_googlemap_styles!==undefined)
		CHARITY_IS_HOPE_STORAGE['googlemap_styles'] = charity_is_hope_theme_googlemap_styles(CHARITY_IS_HOPE_STORAGE['googlemap_styles']);
}
function initMap() {
	var mapDiv = document.getElementById('map');
	var map = new google.maps.Map(mapDiv, {
		center: {
			lat: -27.4979,
			lng: 153.0133
		},
		zoom: 15
	});
}
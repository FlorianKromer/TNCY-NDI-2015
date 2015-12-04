var map;
var myLatlng;
var info={} ;
info["Lat"]="48.669093";
info["Lng"]= "6.154805";
var currentCircle;
var userMarker;

function initialize() {

  var mapCanvas = document.getElementById('map-canvas');
  if(mapCanvas==null){
    return;
  }

  function initMap (infos) {
    myLatlng = new google.maps.LatLng(info["Lat"],info["Lng"])
    var mapOptions = {
      center: myLatlng,
      zoom: 7,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }

    map = new google.maps.Map(mapCanvas, mapOptions)

    userMarker = new google.maps.Marker({
      position: myLatlng,
      map: map
    });


    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
      searchBox.setBounds(map.getBounds());
    });



    searchBox.addListener('places_changed', function() {
    var places = searchBox.getPlaces();

    if (places.length != 1) {
      alert("Please enter a city");
      return;
    }

    var location=places[0].geometry.location;
    userMarker.setPosition(location);
    map.setCenter(location);

    document.getElementById('form_longitude').value=location.lng();
    document.getElementById('form_latitude').value=location.lat();
  });


  }


  if (navigator.geolocation) {
    console.log('Geolocation is supported!');  

    var geoSuccess = function(position) {
      info["Lat"]=position.coords.latitude;
      info["Lng"]=position.coords.longitude;

      initMap(info);
    };
    var geoFail = function(position) {
      initMap(info);
    };
    navigator.geolocation.getCurrentPosition(geoSuccess, geoFail, { timeout: 30000 });

  }else {
    console.log('Geolocation is not supported for this Browser/OS version yet.\n using default position');
    initMap(info);
  }


}

google.maps.event.addDomListener(window, 'load', initialize);
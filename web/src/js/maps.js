var map;
var myLatlng;
var info={} ;
info["Lat"]="48.669093";
info["Lng"]= "6.154805";
var currentCircle;
var userMarker;

var im = 'http://www.robotwoods.com/dev/misc/bluecircle.png';

function initialize() {

  var mapCanvas = document.getElementById('map-canvas');
  if(mapCanvas==null){
    return;
  }



  function initMap (infos) {
    myLatlng = new google.maps.LatLng(info["Lat"],info["Lng"])
    var mapOptions = {
      center: myLatlng,
      zoom: 10,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }

    map = new google.maps.Map(mapCanvas, mapOptions)

    userMarker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            icon: im
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
    console.log('Geolocation is not supported for this Browser/OS version yet.\n using Webapp info');
    initMap(info);
  }


}
google.maps.event.addDomListener(window, 'load', initialize);
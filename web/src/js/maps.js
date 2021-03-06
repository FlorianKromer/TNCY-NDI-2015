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

  console.debug(liste_crise);


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
            map: map,
            icon: im
    });

    liste_crise.forEach(function(crise) {
        var tmpLatLng=new google.maps.LatLng(crise.lat,crise.lng);
        var marker = new google.maps.Marker({
            position: tmpLatLng ,
            map: map,
            title: crise.nom
        });

        var link =  crise.nom.split(' ').join('_')+'/'+crise.id
        var myWindowOptions = {
        content: '<a href="crise/'+link+'">'+crise.nom+' </a>'
        };

        var myInfoWindow = new google.maps.InfoWindow(myWindowOptions);

        // Affichage de la fenêtre au click sur le marker
        google.maps.event.addListener(marker, 'click', function() {
          myInfoWindow.open(map,marker);
        });


        currentCircle=new google.maps.Circle({
          strokeColor: '#198C19',
          strokeOpacity: 0.8,
          strokeWeight: 2,
          fillColor: '#198C19',
          fillOpacity: 0.35,
          map: map,
          center: tmpLatLng,
          radius: crise.rayon * 1000
        });



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
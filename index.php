<?php

$codigo= $_GET['codigo'];

?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <title>Mi ubicación WEB</title>
       <style>
      html, body {
        height: 74%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }

      .controls {
  margin-top: 10px;
  border: 1px solid transparent;
  border-radius: 2px 0 0 2px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
  height: 32px;
  outline: none;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
}

#pac-input {
  background-color: #fff;
  font-family: Roboto;
  font-size: 15px;
  font-weight: 300;
  margin-left: 12px;
  padding: 0 11px 0 13px;
  text-overflow: ellipsis;
  width: 300px;
}

#pac-input:focus {
  border-color: #4d90fe;
}

.pac-container {
  font-family: Roboto;
}

#type-selector {
  color: #fff;
  background-color: #4d90fe;
  padding: 5px 11px 0px 11px;
}

#type-selector label {
  font-family: Roboto;
  font-size: 13px;
  font-weight: 300;
}
 #target {
        width: 345px;
      }
    </style>


    <script>
function enviar() {
var lati=$('#latitud').val();
var longi=$('#longitud').val();
var cod=$('#codigo').val();
if(lati== "" && longi==""){
  alert("No se obtuvo tu ubicación");
}else{
  $.ajax({
url:"https://docs.google.com/forms/d/e/1FAIpQLScdgzvHl2aOTZCVFHrUR6CYcx766gBpMuZulBHsITup-S_W8Q/formResponse",
data:{"entry_100794053":cod,"entry_1893491018":lati,"entry_131480865":longi,"entry_94925917":lati+", "+longi},type:"POST",dataType:"xml"});
alert("Datos guardados");
}}
</script>

 </head>
  <body>

<h2>Obtener ubicación</h2>
<ol>
<li>Para poder obtener tu ubicación es necesario que permitas que podamos acceder a tu ubicación mediante esta página.</li>
<li>En el mapa tienes que colocar el marcador rojo en la ubicación en donde te encuentres. </li>
<li>Por último, presiona el botón "guardar ubicación" y listo.</li>
</ol>
<label>Código: </label><input type="text" readonly="read_only" name="codigo" id="codigo" value="<?php echo $codigo; ?>"/><br><br>
<label>Latitud: </label><input type="text"  readonly="read_only" name="latitud" id="latitud" /><br><br>
<label>Longitud: </label><input type="text" readonly="read_only" name="longitud" id="longitud" /><br><br>
<input type="button" id="guardar" onclick="enviar()" value="Guardar ubicación" />

<br/><br/>
<input id="pac-input" class="controls" type="text" placeholder="Search Box">
 <div id="map"></div>
   
  <script>
var map = null;
var infoWindow = null;
var maker=null;
var pos=null;
function openInfoWindow(marker) {
    
  var markerLatLng = marker.getPosition();
  var contentString = '<b>Mi ubicación</b>';
    infoWindow.setContent(contentString);
    infoWindow.open(map, marker);
    document.getElementById("latitud").value=markerLatLng.lat();
    document.getElementById("longitud").value=markerLatLng.lng();
}
 
function initialize() {

    var myLatlng = {lat: -12.07295497606250, lng: -77.05648645834570};
    var myOptions = {
      zoom: 18,
      center: myLatlng
    }
 
    map = new google.maps.Map(document.getElementById('map'), myOptions);
 
    infoWindow = new google.maps.InfoWindow({map:map});

// Create the search box and link it to the UI element.
  var input = document.getElementById('pac-input');
  var searchBox = new google.maps.places.SearchBox(input);
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
  // Bias the SearchBox results towards current map's viewport.
  map.addListener('bounds_changed', function() {
    searchBox.setBounds(map.getBounds());
  });

     if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var latitud=position.coords.latitude;
      var longitud=position.coords.longitude;
      document.getElementById("latitud").value=latitud;
      document.getElementById("longitud").value=longitud;
      pos = {
        lat: latitud,
        lng: longitud
      };

      infoWindow.setPosition(pos);
      infoWindow.setContent('<b>Ubicación aproximada</b><br>cierra este mensaje y arrastra el punto rojo a tu ubicación');
      map.setCenter(pos);
      marker.setPosition(pos);
      

    }, function() {
      handleLocationError(true, infoWindow, map.getCenter());
    });
  } else {
    // Browser doesn't support Geolocation
    handleLocationError(false, infoWindow, map.getCenter());
  }
    
  function handleLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(browserHasGeolocation ?
                        'Error: El servicio de geolocalización falló.' :
                        'Error: Tu navegador no soporta la geolocalización.');
}
    
     marker = new google.maps.Marker({
        position: myLatlng,
        draggable: true,
        editable: true,
        map: map,
        title:"Marcador arrastrable"
    });
 
    google.maps.event.addListener(marker,'drag', function(){
        openInfoWindow(marker);
    });


    searchBox.addListener('places_changed', function() {

    var places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }

    // For each place, get the icon, name and location.
    var bounds = new google.maps.LatLngBounds();
    places.forEach(function(place) {

     marker.setPosition(place.geometry.location);
    var mark = marker.getPosition();
    document.getElementById("latitud").value=mark.lat();
    document.getElementById("longitud").value=mark.lng();

      if (place.geometry.viewport) {
        // Only geocodes have viewport.
        bounds.union(place.geometry.viewport);
      } else {
        bounds.extend(place.geometry.location);
      }
    });
    map.fitBounds(bounds);
  });
  // [END region_getplaces]


}
 
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDKaQE3wkrMdN3n35vPVIJalGR-Qr1dJaA&libraries=places&callback=initialize"></script>
  </body>
</html>
  

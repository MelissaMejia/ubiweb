<!DOCTYPE html>
<html>
  <head>
    <title>Geolocation</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js">
 </script>
    <style>
      html, body {
        height: 80%;
        width: 100%;   
        padding: 0;
      }
      #map {
        height: 100%;
      }
      .hidden{display:none;}
    </style>

<script>
function enviar() {
var lati=$('#latitud').val();
var longi=$('#longitud').val();
if(lati== "" && longi==""){
  alert("No se obtuvo tu ubicación");
}else{
  $.ajax({
url:"https://docs.google.com/forms/d/e/1FAIpQLScdgzvHl2aOTZCVFHrUR6CYcx766gBpMuZulBHsITup-S_W8Q/formResponse",
data:{"entry_100794053":lati,"entry_94925917":longi},type:"POST",dataType:"xml"});
alert("Datos guardados");
}}
</script>
</head>

<body>

<h2>Obtener ubicación</h2>
<ol>
<li>Para poder obtener tu ubicación es necesario que permitas que podamos acceder a tu ubicación</li>
<li>Presiona el botón guardar ubicación y listo</li>
</ol>
<input type="button" id="guardar" onclick="enviar()" value="Guardar ubicación" />
<input type="text" name="latitud" id="latitud" class="hidden" />
<input type="text" name="longitud" id="longitud" class="hidden"/>

<br/><br/><br/>
 <div id="map" align="center"></div>


<script>
// Note: This example requires that you consent to location sharing when
// prompted by your browser. If you see the error "The Geolocation service
// failed.", it means you probably did not give permission for the browser to
// locate you.

function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: -34.397, lng: 150.644},
    zoom: 16
  });
  var infoWindow = new google.maps.InfoWindow({map: map});

  // Try HTML5 geolocation.
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var latitud=position.coords.latitude;
      var longitud=position.coords.longitude;
      document.getElementById("latitud").value=latitud;
      document.getElementById("longitud").value=longitud;
      var pos = {
        lat: latitud,
        lng: longitud
      };

      infoWindow.setPosition(pos);
      infoWindow.setContent('Ubicación encontrada.');
      map.setCenter(pos);
    }, function() {
      handleLocationError(true, infoWindow, map.getCenter());
    });
  } else {
    // Browser doesn't support Geolocation
    handleLocationError(false, infoWindow, map.getCenter());
  }
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(browserHasGeolocation ?
                        'Error: El servicio de geolocalización falló.' :
                        'Error: Tu navegador no soporta la geolocalización.');
}

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDKaQE3wkrMdN3n35vPVIJalGR-Qr1dJaA&callback=initMap"
        async defer>
    </script>
  </body>
</html>
  

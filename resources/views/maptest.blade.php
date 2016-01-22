<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Simple Polylines</title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
    <script>
// This example creates a 2-pixel-wide red polyline showing
// the path of William Kingsford Smith's first trans-Pacific flight between
// Oakland, CA, and Brisbane, Australia.

function initialize() {

  var mapOptions = {
    zoom: 3,
    center: new google.maps.LatLng(0, -180),
    mapTypeId: google.maps.MapTypeId.TERRAIN
  };

  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

    var flightPlanCoordinates = [];
    var bounds = new google.maps.LatLngBounds();

    $.post('/power/map',{id:13},function(response){

        $.each(response,function(index, value) {
           flightPlanCoordinates.push(new google.maps.LatLng(value[0], value[1]))
            bounds.extend(new google.maps.LatLng(value[0], value[1]));
        });

        var flightPath = new google.maps.Polyline({
            path: flightPlanCoordinates,
            geodesic: true,
            strokeColor: '#FF0000',
            strokeOpacity: 1.0,
            strokeWeight: 3
        });

        flightPath.setMap(map);
        map.fitBounds(bounds);
        //flightPlanCoordinates.push(new google.maps.LatLng(37.772323, -122.214897),)
    },'JSON')
    console.log(flightPlanCoordinates);
//  var flightPlanCoordinates = [
//    new google.maps.LatLng(37.772323, -122.214897),
//    new google.maps.LatLng(21.291982, -157.821856),
//    new google.maps.LatLng(-18.142599, 178.431),
//    new google.maps.LatLng(-27.46758, 153.027892)
//  ];
   console.log(flightPlanCoordinates);

}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
  <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
</html>
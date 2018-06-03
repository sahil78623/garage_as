<?php
  session_start();
    include_once("navigation.php");
 ?>
<html>
<head>
<link href="estimation.css" type="text/css" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDRCP27ppEAZ-yQDkJdYMQg18yepmPJz04" type="text/javascript"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</head>
<body>
  <div class="container">
<center>
<div class="row">
            <h3>Get my pick up location:</h3>
      </div>

    <div class="row">
    <button style="margin-bottom: 5px"onclick="getMyLocation()" style="font-size:18px">My Location<i class="material-icons">location_on</i></button>
    </div>

    <button onclick="getDistance()">Get Estimations of Service </button>

    <h2>Service At:</h2>
        <p id="serviceAt"></p> </br>
    <h2>Estimation Cost:</h2>
        <p id="estCost"></p></br>
    <h2>Estimated Delivery Time:</h2><p id="deliveryTime"></p>

    <form method="post" action="payment.php">
         <input type="submit" value="Check Out" class="checkout">
    </form>
  </center>
</div>
<script>

var dist;
var currentLatLng;
var serviceLatLng;


// Get the service center lat and lng
serviceLatLng = new google.maps.LatLng(17.473633, 78.364535);

// Get current location
function getMyLocation(){
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}



function showPosition(position) {
    var lat;
    var lng;
    lat = position.coords.latitude;
    lng = position.coords.longitude;


    currentLatLng = new google.maps.LatLng(lat,lng);
    //console.log("lat: "+);
    console.log("lng: "+lng);
}


function getDistance(){

var service = new google.maps.DistanceMatrixService();
service.getDistanceMatrix(
{
    origins: [currentLatLng],
    destinations: [serviceLatLng],
    travelMode: 'DRIVING',
    avoidHighways: true,
    avoidTolls: true,
}, callback);
}

function callback(response,status){

 //   alert(JSON.stringify(response.rows[0].elements[0].distance.text));
  dist = response.rows[0].elements[0].distance.text;

  var serviceAt = document.getElementById('serviceAt');
  serviceAt.innerHTML = 'Varun Bajaj, Kondapur';

  var estCost = document.getElementById('estCost');
  estCost.innerHTML = 'RS: ' + parseInt((parseInt(dist) * 2.6* 2) + 50) ;
  //alert(dist);

  var deliveryTime = document.getElementById('deliveryTime');
  deliveryTime.innerHTML = '1 Day';

}

// Get from address to coordinate
function addrCoordinate(){
var source = document.getElementById("source").value;
var encodedAddr = encodeURIComponent(source);
var xhttp = new XMLHttpRequest();

xhttp.onreadystatechange = function() {
if (this.readyState == 4 && this.status == 200) {
    console.log(this.responseText.results[0].geometry.location.lat);
}
};
xhttp.open("GET", `https://maps.googleapis.com/maps/api/geocode/json?address=${encodedAddr}`, true);
xhttp.send();
}
</script>

</body>
</html>

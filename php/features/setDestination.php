<!DOCTYPE html>
<html
     lang="en-US">
<!------------------------ Html Document definitions and page setups ------------------------>
<head>
<link rel="shortcut icon" href="../media/fav_icon/fav.png" />
<link rel="stylesheet" href="../css/jquery-ui.css" />
<title>Welcome to SLPA Vehicle Tracking System</title>
<meta name="keywords"
     content="srilanka port authority, SLPA,UOM,FIT,vehicle tracking system" />
<!--  SEO meta contents keywords -->
<meta name="author"
     content="University Of Moratuwa Faculty Of Information Technology" />
<meta name="description"
     content="Vehicle Tracking System for Srilanka Port Authority" />
<meta charset="UTF-8" />
<!------------------------ End ------------------------>

<!-- CSS style sheet for Leaflet API from online CDN -->




<link rel="stylesheet" href="../../css/leaflet.css" />

<!------------------------------------------------ End ------------------------------------------------>

<!-------------------------- JavaScript file for Leaflet API from online CDN -------------------------->

<script src="../../js/leaflet.js"></script>

<!------------------------------------------------ End ------------------------------------------------>

<!-------------------------- Javascript JQuery 1.8.3 API for animations and AJAX -------------------------->

<script src="../../js/jquery-1.8.3.js"></script>

<script src="../../js/jquery-ui-1.9.2.js"></script>

<!------------------------------------------------ End ------------------------------------------------>
<script type="text/javascript">
function createMap(){
     var map = L.map('destinationMap').setView([7.05826, 79.93961], 13);



     var myMapToSetDestination = L.tileLayer("http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
         attribution: 'SysCall',
         maxZoom: 18
     }).addTo(map);

     map.on("click",getCoordinates); 

	     
}
$(document).ready(function (){

	createMap();
	
});

function getCoordinates(passedObject){
    
   var latitude = passedObject.latlng.lat;
   var longitude = passedObject.latlng.lng;
   
   alert("Latitude = "+latitude+"\n Longitude = "+longitude);
	     
}
</script>
</head>
<body>

<div id="destinationMap" style="width: 500px;height: 500px">
map
</div>

</body>

</html>

<?php
?>
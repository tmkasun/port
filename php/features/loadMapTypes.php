<?php session_start();

//session start to identify login users and etc

/*
 * Message for developers:
 *
 *
 *
 *
 *
 * */



if(!isset($_SESSION["computer_number"])){
     header('Location: ../index.php');


}


?>
<html>

<img alt='Google maps' width='50%' onclick="changeMapTileServer('googleMap')" src='../media/images/icons/googleMaps.png'/><br/><span style="color: fuchsia;">Google Maps</span><br/>
<img alt='Opeen Streat Maps' width='50%' onclick="changeMapTileServer('OSM')" src='../media/images/icons/openStreet.png'/><br/><span style="color: fuchsia;">Open Street Maps </span><br/>

<img alt='Local GoogleMaps' width='50%' onclick="changeMapTileServer('localGoogleMaps')" src='../media/images/icons/network_local.png'/><br/><span style="color: fuchsia;">Googel Maps (Local)</span><br/>
<img alt='Local virtualEarth' width='50%' onclick="changeMapTileServer('localVirtualEarth')" src='../media/images/icons/network_local.png'/><br/><span style="color: fuchsia;">Virtual Earth (Local)</span><br/>
<img alt='Local OpenStreetMap' width='50%' onclick="changeMapTileServer('OpenStreetMap')" src='../media/images/icons/network_local.png'/><br/><span style="color: fuchsia;">Open Street Maps (Local)</span><br/>


</html>
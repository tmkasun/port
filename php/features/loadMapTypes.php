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

<img alt='Google maps' width='50%' onclick="changeMapTileServer('googleMap')" src='../media/images/icons/googleMaps.png'/><br/>Google Maps<br/>
<img alt='Opeen Streat Maps' width='50%' onclick="changeMapTileServer('OSM')" src='../media/images/icons/openStreet.png'/><br/>Open Street Maps <br/>

<img alt='Local GoogleMaps' width='50%' onclick="changeMapTileServer('localGoogleMaps')" src='../media/images/icons/network_local.png'/><br/>Googel Maps (Local)<br/>
<img alt='Local virtualEarth' width='50%' onclick="changeMapTileServer('localVirtualEarth')" src='../media/images/icons/network_local.png'/><br/>Virtual Earth (Local)<br/>
<img alt='Local OpenStreetMap' width='50%' onclick="changeMapTileServer('OpenStreetMap')" src='../media/images/icons/network_local.png'/><br/>Open Street Maps (Local)<br/>


</html>
<?php
session_start();

$imei = $_GET["deviceImeiNumber"];
$year = $_GET["year"];
$month = $_GET["month"];
$date = $_GET["date"];

require_once '../mysql/local.php';

$getVehicleListSQL = "select latitude,longitude,sat_time from coordinates where imei = '$imei' and sat_time like '$year-$month-$date %' order by sat_time asc";

//die($year.">>>>>".$month.">>>".$date.">>>>>".$getVehicleListSQL);
$sqlResultObject = mysql_query($getVehicleListSQL,$connection);


while($tuple = mysql_fetch_assoc($sqlResultObject)){
     
     $transferArray[] = $tuple;
     
}
print json_encode($transferArray);

     ?>
     
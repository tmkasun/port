<?php
session_start();

$imei = $_GET["deviceImeiNumber"];
$year = $_GET["year"];
$month = $_GET["month"];
$date = $_GET["date"];
$start = $_GET["start"];
$end = $_GET["end"];

require_once '../mysql/local.php';

$getVehicleListSQL = "select latitude,longitude,sat_time from coordinates where imei = '$imei' and date(sat_time) = '$year-$month-$date' and  time(sat_time) between '$start:00' and '$end:00'";
//die($year.">>>>>".$month.">>>".$date.">>>>>".$getVehicleListSQL);

$sqlResultObject = mysql_query($getVehicleListSQL,$connection);


while($tuple = mysql_fetch_assoc($sqlResultObject)){
     
     $transferArray[] = $tuple;
     
}
print json_encode($transferArray);

     ?>
     
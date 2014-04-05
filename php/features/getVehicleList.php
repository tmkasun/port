<?php
session_start();

require_once '../mysql/local.php';

$getVehicleListSQL = "select assigned_imei_number as imei, vehicle_registration_number from vehicle_details";

$sqlResultObject = mysql_query($getVehicleListSQL,$connection);


while($tuple = mysql_fetch_assoc($sqlResultObject)){
     
     $transferArray[] = $tuple;
     
}
print json_encode(array('results' => $transferArray));

     
     


?>
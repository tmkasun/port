<?php
session_start();

require_once '../mysql/local.php';

$getVehicleHistoryDates = "select date(sat_time) as dates from coordinates where imei = '". $_POST["imei"] ."' group by date(sat_time);";

$sqlResultObject = mysql_query($getVehicleHistoryDates,$connection);

while($row = mysql_fetch_array($sqlResultObject)){
	//$table_data[] = $row;
	$table_data[]= array("dates"=>$row['dates']);
}
echo json_encode($table_data);




?>
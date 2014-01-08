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



if(!$_SESSION["computer_number"])
die("Please Login");


//check the connection type, if running in local server import local setting else import other setting
//this is for compatibility from local and remote use
include_once('./mysql/local.php');

$select_currect_vehicles = "select * from (select imei,sat_time,latitude,longitude,speed,bearing from coordinates order BY imei,sat_time desc) as mid where mid.imei in (select imei from vehicle_status where current_status = 1) group by mid.imei";


if(isset($_POST["firstTime"])){
$select_currect_vehicles = "select * from (select imei,sat_time,latitude,longitude,speed,bearing from coordinates order BY imei,sat_time desc) as mid group by mid.imei";
}
//die($select_currect_vehicles);

$query_result = mysql_query($select_currect_vehicles,$connection);
error_reporting(E_PARSE);

while($row = mysql_fetch_array($query_result)){
	//$table_data[] = $row;
	$table_data[]= array("imei"=>$row['imei'],"sat_time"=>$row['sat_time'],"latitude"=>$row['latitude'],"longitude"=>$row['longitude'],"speed" => $row["speed"],"bearing" => (int)$row["bearing"] );
}
echo json_encode($table_data);
//header('Content-Type: application/json');

//comment out for echo jason array test
//while ($row = mysql_fetch_array($query)){

?>


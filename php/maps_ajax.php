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
if($_SERVER[REMOTE_ADDR] == '127.0.0.1'){
	include_once('./mysql/local.php');
}
else
include_once('./mysql/remote.php');

$select_currect_vehicles = "select * from (select imei,sat_time,serial,latitude,longitude,speed from coordinates order BY imei,sat_time desc) as mid where mid.imei in (select imei from vehicle_status where current_status = 1) group by mid.imei";


if(isset($_POST["firstTime"])){
$select_currect_vehicles = "select * from (select imei,sat_time,serial,latitude,longitude,speed from coordinates order BY imei,sat_time desc) as mid group by mid.imei";
     
     
}


$query_result = mysql_query($select_currect_vehicles,$connection);
error_reporting(E_PARSE);

while($row = mysql_fetch_array($query_result)){
	//$table_data[] = $row;
	$table_data[]= array("imei"=>$row['imei'],"serial"=>$row['serial'],"sat_time"=>$row['sat_time'],"latitude"=>$row['latitude'],"longitude"=>$row['longitude'],"speed" => $row["speed"]);
}
echo json_encode($table_data);
//header('Content-Type: application/json');

//comment out for echo jason array test
//while ($row = mysql_fetch_array($query)){

?>


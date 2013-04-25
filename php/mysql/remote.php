<?php
$connection = mysql_connect("127.0.0.1","114150B","114150B");//Connecting to mysql server

if(!$connection){//test whether the connection has established 
print mysql_error();
die;
}
mysql_select_db("114150B_...",$connection);//select uni database from mysql engine

?>


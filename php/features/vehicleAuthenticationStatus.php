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

//check the connection type, if running in local server import local setting else import other setting
//this is for compatibility from local and remote use
if($_SERVER[REMOTE_ADDR] == '127.0.0.1'){
     include_once('../mysql/local.php');
}
else
include_once('../mysql/remote.php');
print "<br/>";


$vehicle_authentication_check = "select * from approved_imei,not_approved_imei order by review_status desc";

$query_result = mysql_query($vehicle_authentication_check,$connection);
error_reporting(E_PARSE);


//create table for display authentification details
?>
<div id="td"
     style="position: relative; margin: 0; margin-left: 10%; float: left; width: 80%; height: auto; padding-bottom: 10%; background: #BCBCBC; text-align: center;">
     
<table border="1"
     style="border-width: 1px; border-bottom-color: blue; border-style: dotted; border-radius: 10px;">
     <tr>
          <th
               style="border-width: 1px; border-color: blue; border-style: solid; border-radius: 10px;">Vehicle
               IMEI Number</th>
          <th
               style="border-width: 1px; border-color: blue; border-style: solid; border-radius: 10px;">Authentication
               Status</th>
          <th
               style="border-width: 1px; border-color: blue; border-style: solid; border-radius: 10px;">Review
               Status</th>
     </tr>




     <?php

     $number_of_vehicles = 0;
     while($row = mysql_fetch_array($query_result)){

          $number_of_vehicles +=1;
          ?>
     <tr>
          <td><?php print $row["imei"]?>
          </td>
          <td><?php print "need a algorithem for this"?>
          </td>
          <td><?php 
          if ($row["review_status"]== 0){
               ?>
               <img onclick="alert('ok')" alt="New" src="../../media/images/icons/new_violet.png">
               <?php 
          }
          else {
               ?>
               <img onclick="alert('ok')" alt="New" src="../../media/images/icons/splash_violet.png">
               <?php 
          }



          ?></td>
     </tr>


     <?php

     }

     ?>
</table>
</div>
     <?php
     print "Number of vehicles in the list".$number_of_vehicles;
     ?>

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

if(isset($_POST["decision"])){
      
     switch ($_POST["decision"]) {
          case "approve":
               $set_approval = "insert into approved_imei values('$_POST[imei]',now())";
              // $update_review_flag = "update not_approved_imei set review_status = 1 where imei = '$_POST[imei]'";
			   $delete_review_flag = "delete from not_approved_imei where imei = '$_POST[imei]'";
			   $add_vehicle_details = "insert into vehicle_details(assigned_imei_number,vehicle_registration_number,vehicle_owner) values('$_POST[imei]','$_POST[vehicle_registration_number]','$_POST[vehicle_owner]')";
			   mysql_query($add_vehicle_details,$connection);
			   			   
               mysql_query($set_approval,$connection);
               mysql_query($delete_review_flag,$connection);
               print "approve >".$_POST["imei"]."ok >".$query_result;
               break;

          case "reject":
               $update_review_flag = "update not_approved_imei set review_status = 1 where imei = '$_POST[imei]'";
               mysql_query($update_review_flag,$connection);
               print "reject".$_POST["imei"];;
               break;
     }
      
      
     die();
}

print "<br/>";

$approved_imei_display = "select * from approved_imei order by approved_on";
$query_result_approved = mysql_query($approved_imei_display,$connection);

$results_approved = array();
		$r=0;
		while ($row = mysql_fetch_array($query_result_approved,MYSQL_NUM)) { 
		  $c=0;
		  foreach($row as $rs){
			$results_approved[$r][$c]=$rs;
			 $c++;
		  }
		  $r++;
		}
		
		$count_approved = sizeof($results_approved);
		
$not_approved_imei_display = "select imei, first_connected_on from not_approved_imei where review_status = 1  order by first_connected_on desc";
$query_result_not_approved = mysql_query($not_approved_imei_display,$connection);

$results_not_approved = array();
		$r=0;
		while ($row = mysql_fetch_array($query_result_not_approved,MYSQL_NUM)) { 
		  $c=0;
		  foreach($row as $rs){
			$results_not_approved[$r][$c]=$rs;
			 $c++;
		  }
		  $r++;
		}
		
		$count_not_approved = sizeof($results_not_approved);
		
$vehicle_authentication_check = "select * from not_approved_imei where review_status = 0  order by first_connected_on desc";

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
               <th
                    style="border-width: 1px; border-color: blue; border-style: solid; border-radius: 10px;">First
                    connected on</th>
               <th
                    style="border-width: 1px; border-color: blue; border-style: solid; border-radius: 10px;">Approved on</th>
          </tr>




          <?php

          $number_of_vehicles = 0;
          while($row = mysql_fetch_array($query_result)){

               $number_of_vehicles +=1;
               ?>
          <tr>
               <td><?php print $row["imei"]?>
               </td>
               <td><?php print "Approval is Pnding"?>
               </td>
               <td><?php 
               if ($row["review_status"]== 0){
                    ?> <img
                    onclick="setDecision('<?php print $row["imei"]?>','approve')"
                    alt="New"
                    src="../media/images/icons/vehicleApproval/approve.png">
                    <img
                    onclick="setDecision('<?php print $row["imei"]?>','reject')"
                    alt="New"
                    src="../media/images/icons/vehicleApproval/reject.png">
                    <?php
               }
               else {
                    ?> <img onclick="alert('ok')" alt="New"
                    src="../media/images/icons/splash_violet.png"> <?php 
          }



          ?></td>
               <td><?php print $row["first_connected_on"]?>
               </td>
               <td>Pending</td>
          </tr>
          <?php
               }
		  for($i = 0 ; $i < $count_approved ; $i++)
		  {
			  echo "<tr><td>";
			  echo $results_approved[$i][0];
			  echo "</td><td>Approved</td><td>";
			  echo "<img src='../media/images/icons/vehicleApproval/ok.png'/>";
			  echo "</td><td>----</td><td>";
			  echo $results_approved[$i][1];
			  echo "</td></tr>";
		  }
		   for($j = 0 ; $j < $count_not_approved; $j++)
		  {
			  echo "<tr><td>";
			  echo $results_not_approved[$j][0];
			  echo "</td><td>Not Approved</td><td>";
			  echo "<img src='../media/images/icons/vehicleApproval/ok.png'/>";
			  echo "</td><td>";
			  echo $results_not_approved[$j][1];
			  echo "</td><td>----</td></tr>";
		  }
?>

         
     </table>
</div>
<?php
     print "Number of vehicles in the list".$number_of_vehicles;
     ?>

<?php
session_start();

  //echo "dinuka";
  
  require_once '../mysql/local.php';
  
$approved_imei_display = "select imei from approved_imei order by approved_on";
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
		
		 
?>
<html>
  <head>
  	<link rel="stylesheet" href="http://flip.hr/css/bootstrap.min.css" type="text/css" />
  </head>
  <body>
  	<div class="container">
  	<div class="alert alert-info"> 
	                    <h4>Note :-</h4>
	                    <p>
	                    	Please select one of the following vehicles to see its fuel status
	                    </p>
	    </div>
  	<?php
  	  echo "<table class='table table-striped'>";
		for($i = 0 ; $i < $count_approved ; $i++)
		  {
			  echo "<tr><td>";
			  echo $results_approved[$i][0];
			  echo "<td>   </td>";
			  echo "</td><td><a href='displayEngineFuelStateOfVehicle.php?vehicleIdentificationNumber=".$results_approved[$i][0]."'>Show Fuel lvel</a>";
			  echo "</td></tr>";
		  }
		  echo "</table>";
  	?>
  	</div>
  </body>
</html>
   
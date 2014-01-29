<?php
session_start();
require_once '../mysql/local.php';

/*
*
*This is a prototype and most of the values are hardcoded.
*Need to congigure databases
*/
//
 
$vehicle_imei_number = $_GET['vehicleIdentificationNumber'];

 
$vehicle_details = "select * from vehicle_details where assigned_imei_number =".$vehicle_imei_number;
$query_result_details = mysql_query($vehicle_details,$connection);

$results_details = array();
		$r=0;
		while ($row = mysql_fetch_array($query_result_details,MYSQL_NUM)) { 
		  $c=0;
		  foreach($row as $rs){
			$results_details[$r][$c]=$rs;
			 $c++;
		  }
		  $r++;
		}
		
		$count_details = sizeof($results_details);  
?>

<html>
  <head>
  	<link rel="stylesheet" href="http://flip.hr/css/bootstrap.min.css" type="text/css" />
    <script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
      google.load('visualization', '1', {packages:['gauge']});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Fuel', 80],
          ['Fuel', 55], 
          ['Fuel', 68]
        ]);

        var options = {
          width: 1000, height: 600,
          redFrom: 90, redTo: 100,
          yellowFrom:75, yellowTo: 90,
          minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('chart_div'));
        chart.draw(data, options);
      }


    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart1);
      function drawChart1() {
        var data1 = google.visualization.arrayToDataTable([
          ['Time', 'Fuel_Level'],
          ['6 A.M',  100],
          ['7 A.M',   60],
          ['8 A.M',   20],
          ['9 A.M',   30],
          ['10 A.M',   20],
          ['11 A.M',   30],
          ['12 A.M',   20],
          ['1 P.M',   30],
          ['2 A.M',   20],
          ['3 A.M',   30],
          ['4 A.M',   20],
          ['5 A.M',   30]
        ]);

        var options1 = {
          title: 'Fuel Consumption',
          hAxis: {title: 'Time',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div1'));
        chart.draw(data1, options1);
      }

    </script>  
  </head>
  <body>
  	<div class="container">
     <div class="alert alert-warning">   	
	     <h3>The following Graph describe the fuel level of the vehicle of Today</h3>
	  	 <div id='chart_div'></div> 
	  	 <div class="alert alert-success">
	  		<table>
	  			<tr>
	  				<td>
	  					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  					&nbsp;&nbsp;&nbsp; 				
	  				</td>
	  				<td><h4>12 Hours ago</h4></td>
	  				<td>
	  					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  					    &nbsp;&nbsp;&nbsp;&nbsp;					
	  				</td>
	  				<td><h4>6 ours ago</h4></td>
	  				<td>
	  					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	  					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 					
	  				</td>
	  				<td><h4>Now</h4></td>
  			   </tr>
  		    </table>
        </div>
	    <div class="alert alert-danger"> 
	                    <h4>Note :-</h4>
	                    <p>
	                    	This shows the fuel levels of the vehicle in last 12 hours.
	                    </p>
	    </div>
			  	
	    <div id='chart_div1'></div> 
	  	
			  	<?php
					  	echo "<h3>The vehicle details as follows</h3>";					  	
					  	echo "<table border ='0' class='table table-striped'>";
					      echo "<tr>";
					        echo "<td>"; 
						       echo "Vehicle Imei number" ;
						    echo "</td>";
						    echo "<td>";
					           echo $vehicle_imei_number;
						  echo "</td></tr>";
						
						 echo "<tr><td>Vehicle Registration Number</td>";
						 echo "<td>";
						 echo $results_details[0][1];
						 echo "</td></tr>";
						
						 echo "<tr><td>Vehicle Type</td>";
						 echo "<td>";
						 echo $results_details[0][2];
						 echo "</td></tr>";
						 
						  echo "<tr><td>Vehicle Owner</td>";
						 echo "<td>";
						 echo $results_details[0][3];
						 echo "</td></tr>";
					  	
		    	?>
		  	</div>
  	 </div>
  </body>
</html>
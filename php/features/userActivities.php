<?php session_start(); ?>
<!DOCTYPE HTML>
<?php

include_once('../mysql/local.php');

$get_details = "select * from track order by date_time desc";
$result = mysql_query($get_details,$connection);
?>
<div id="td"
	style="position: relative; margin: 0; margin-left: 10%; float: left; width: 80%; height: auto; padding-bottom: 10%; background: #BCBCBC; text-align: center;">
<table id="tt" border="1"
	; style="position: relative; width: 100%; table-layout: auto; background-color: #000000; color: #ff0000; text-align: center;">
	<thead>
		<tr style="font-style: oblique; color: #00FF11;">
			<td>Hit Count</td>
			<td>Computer Number</td>
			<td>Date And Time</td>
			<td>IP Address</td>
		</tr>
	</thead>
	<?php
	while($rows = mysql_fetch_array($result)){
		?>
	<tr>
		<td><?php print $rows["hit_count"] ?></td>
		<td><?php print $rows["computer_number"] ?></td>
		<td><?php print $rows["date_time"] ?></td>
		<td><?php print $rows["ip_addr"] ?></td>
	</tr>
	<?php
	}
	?>
</table>
</div>

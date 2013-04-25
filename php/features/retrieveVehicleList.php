<?php
session_start();

require_once '../mysql/local.php';

$getVehicleListSQL = "select imei from coordinates group by imei";

$sqlResultObject = mysql_query($getVehicleListSQL,$connection);

while($tuple = mysql_fetch_assoc($sqlResultObject)){
     ?>
     
     <a><img onclick="leftSidePaneImageOnClick(this)" alt="Vehicle" src="../../media/images/icons/truck.png" id = "<?php print $tuple['imei']?>" style="margin-left: 15px;margin-top: 15px"/>
     </a>
     <p >Truck Name</p>
     
     
     
     <?php 
     
     
     
}


?>
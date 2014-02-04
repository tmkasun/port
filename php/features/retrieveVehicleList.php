<?php
session_start();

require_once '../mysql/local.php';

$getVehicleListSQL = "select assigned_imei_number as imei, vehicle_registration_number from vehicle_details";

$sqlResultObject = mysql_query($getVehicleListSQL,$connection);

while($tuple = mysql_fetch_assoc($sqlResultObject)){
     ?>
     
     <a style="cursor: pointer;"><img onclick="leftSidePaneImageOnClick(this)" alt="Vehicle" src="../media/images/icons/truck.png" imei = "<?php print $tuple['imei']?>" style="margin-left: 15px;margin-top: 15px"/>
     </a>
     <p style="color: fuchsia;" ><?php print $tuple['vehicle_registration_number']?></p>
     
     
     
     <?php 
     
     
     
}


?>
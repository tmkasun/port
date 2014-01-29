<?php session_start();

//print $_SESSION["reg_number"];
session_destroy();
//print $_SESSION["reg_number"];
clearstatcache();
header("location: ../index.php");
?>

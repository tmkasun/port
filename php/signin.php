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

if ($_POST["retry"])
header('Location: ./');

//null password or direct call to singup.php
if (!$_POST["password"]){

	die("NULL_Password");
}
?>

<?php
//debug
/*
 echo("Username => ".$_POST['username']."password => ".$_POST['password']);
 die();
 */
//debug --end
if( strlen($_POST['username']) != 6 ){
	print "wrong_username";

	die();
}
?>

<?php



//check the connection type, if running in local server import local setting else import other setting
//this is for compatibility from local and remote use
if($_SERVER[REMOTE_ADDR] == '127.0.0.1'){
	include_once('./mysql/local.php');
}
else
include_once('./mysql/remote.php');



#mysql_select_db("114150B_un",$connection);//select uni database from mysql engine
$md5 = md5($_POST[password]);//secured from MYSQL injections
//print $md5;
$check = "select null from logins where computer_number = '$_POST[username]' and password = '$md5'";

$result = mysql_query($check,$connection);//query send to mysql database to check username and password

$row = mysql_fetch_array($result);

if (!$row){

	//911 for wrong password code for ajax
	die("911");
}
?>



<?php
if($row){

	$_SESSION["computer_number"] = $_POST["username"];
	//administrator loging cheack
	$admin_chk = "select null from administrators where computer_number = '$_SESSION[computer_number]'";
	$admin_rs = mysql_query($admin_chk,$connection);
	$get = mysql_fetch_row($admin_rs);
	if($get){
		echo("Administrative account");
		$_SESSION["admin"] = true;
	}
	else 
		$_SESSION["admin"] = false;

	//administrator cheack script end --

	$mysql_date_time = date("Y-m-d H:i:s");
	//print $_POST[username].$mysql_date_time.$_SERVER[REMOTE_ADDR];
	//track users login details for security  useses, administrators can retrive information from track table
	$hit_count = "insert into track(computer_number,date_time,ip_addr) values('$_POST[username]','$mysql_date_time','$_SERVER[REMOTE_ADDR]')";


	mysql_query($hit_count,$connection);
	echo("correct_password_#145Akcode_214QW_code_");
	?>
<html>
<head>
<link rel="shortcut icon" href="../media/fav_icon/fav.png" />
<script>
            function strt(){
                window.location.href = "./maps.php";
            }
        </script>

</head>
<body id="body" style="border: 0;">

	<div id="trolle"
		style="position: absolute; float: left; margin-top: 0%; width: auto; height: auto; text-align: center; margin-left: 50%;">
		<img width="50%" height="50%" src="./mm/dtf.gif" />
	</div>
	<div id="startup"
		style="position: relative; float: left; margin: 0; margin-left: 25%; width: 50%; margin-top: 10%; height: auto; background-image: url(./mm/bg_dotted.png); margin-bottom: 25%; text-align: center;">

		<img src="./mm/loading143.gif" /> <br /> Prossesing Your Request
		......
		<script>
        setTimeout(strt,1200);
    </script>

	</div>

	<?php
}
?>
	<!--____________________________________________________________________________________________________________________-->
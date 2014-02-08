<?php session_start();

if(isset($_SESSION["computer_number"])){
     header('Location: ./php/maps.php');
     
     
}

include_once("./php/features/googleAnalyticsTracking.php")


?>
<!DOCTYPE html>
<html lang="en-US">

	<!--
	Message for developers:
	on submit return
	on press value check

	-->

	<head>

		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Bootstrap -->
		<link href="./css/bootstrap.min.css" rel="stylesheet">
		<script src="./js/bootstrap.min.js"></script>

		<link rel="shortcut icon" href="./media/fav_icon/fav.png" />
		<link  rel="stylesheet" href="./css/Gbuttons.css">

		<title>Welcome to SLPA Vehicle Tracking System</title>
		<meta name="keywords"
		content="srilanka port authority, SLPA,UOM,FIT,vehicle tracking system" />
		<!--  SEO meta contents keywords -->
		<meta name="author"
		content="University Of Moratuwa Faculty Of Information Technology" />
		<meta name="description"
		content="Vehicle Tracking System for Srilanka Port Authority" />
		<meta charset="UTF-8" />
		<!-- NO CCS styles for loging page inline styles has been used  -->
		<!-- link href="./css/styles.css" rel="stylesheet" type="text/css" / -->

		<script src="./js/jquery-1.8.3.js"></script>

		<script src="./js/jquery-ui-1.9.2.js"></script>

		<style>
			/*==================================================
			 * Effect 8
			 * ===============================================*/
			.effect8 {
				position: relative;
				-webkit-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
				-moz-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
				box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
			}
			.effect8:before, .effect8:after {
				content: "";
				position: absolute;
				z-index: -1;
				-webkit-box-shadow: 0 0 20px rgba(0,0,0,0.8);
				-moz-box-shadow: 0 0 20px rgba(0,0,0,0.8);
				box-shadow: 0 0 20px rgba(0,0,0,0.8);
				top: 10px;
				bottom: 10px;
				left: 0;
				right: 0;
				-moz-border-radius: 100px /10px;
				border-radius: 100px /10px;
			}
			.effect8:after {
				right: 10px;
				left: auto;
				-webkit-transform: skew(8deg) rotate(3deg);
				-moz-transform: skew(8deg) rotate(3deg);
				-ms-transform: skew(8deg) rotate(3deg);
				-o-transform: skew(8deg) rotate(3deg);
				transform: skew(8deg) rotate(3deg);
			}

			body {
				background: radial-gradient(circle, rgb(148 210, 248), rgb(58, 146, 200)) repeat scroll 0% 0% transparent;
				background-color: transparent;
				background-image: radial-gradient(circle, rgb(148, 210, 248), rgb(58, 146, 200));
				background-repeat: repeat;
				background-attachment: scroll;
				background-position: 0% 0%;
				background-clip: border-box;
				background-origin: padding-box;
				background-size: auto auto;
				background: radial-gradient(circle, rgb(148, 210, 248), rgb(58, 146, 200)) repeat scroll 0% 0% transparent;
				background-color: transparent;
				background-image: radial-gradient(circle, rgb(148, 210, 248), rgb(58, 146, 200));
				background-repeat: repeat;
				background-attachment: scroll;
				background-position: 0% 0%;
				background-clip: border-box;
				background-origin: padding-box;
				background-size: auto auto;
				background: radial-gradient(circle, rgb(148, 210, 248), rgb(58, 146, 200)) repeat scroll 0% 0% transparent;
				background-color: transparent;
				background-image: radial-gradient(circle, rgb(148, 210, 248), rgb(58, 146, 200));
				background-repeat: repeat;
				background-attachment: scroll;
				background-position: 0% 0%;
				background-clip: border-box;
				background-origin: padding-box;
				background-size: auto auto;
			}
			.fixer {
				padding: 0 15px;
				margin: auto;
			}
		</style>

		<script type="text/javascript">
			//block tring after 3 attempt
			var try_count = 0;
			function trys() {
				//alert("testing");
				if (try_count > 2) {
					alert("you have exceeded the maximum number of login attempts!");
					return false;
				} else {
					try_count += 1;
					return true;
				}
			}

			//block tring after 3 attempt end--

			//ajax supported loging method
			var signin_ajax = new XMLHttpRequest();
			function ajax_return() {

				var response = "";
				if (signin_ajax.readyState == 4 && signin_ajax.status == 200) {
					response = signin_ajax.responseText;
					//alert(response);
					match_wrong_password = response.match("911");
					match_correct_password = response.match("correct_password_#145Akcode_214QW_code_");
					correct_bt_nt_auth = response.match("notapp");
					//911 for wrong password code

					if (match_wrong_password) {
						//alert("Wrong Password");
						//login and password are the id of username and password input tags :)
						document.getElementById("login").style.boxShadow = "0px 1px 5px 1px #F90000";
						document.getElementById("login").style.borderColor = "red";
						$("#login").effect("shake", 500);
						document.getElementById("password").style.borderColor = "red";
						document.getElementById("password").style.boxShadow = " 0px 1px 5px 1px #F90000";
						setTimeout(function() {
							$("#password").effect("shake", 500);
						}, 100);
						$("#submit_button").fadeIn("slow");
						document.getElementById("loading_image").style.display = "none";
						return false;
					} else if (match_correct_password) {

						//alert("Correct Password");
						$("#fit11").fadeOut("slow");
						setTimeout(function() {
							$("#computer_number").effect("drop", {
								direction : "right"
							}, 500);
						}, 200);
						$("#login").effect("drop", {
							direction : "right"
						}, 200);
						$("#submit_button").fadeOut("slow");

						setTimeout(function() {
							$("#password").effect("drop", {
								direction : "left"
							}, 500);
						}, 200);
						$("#pass").effect("drop", {
							direction : "left"
						}, 500);

						setTimeout(function() {
							$("#Sign_in").slideUp({
								direction : "up"
							}, 500);
						}, 800);
						setTimeout(function() {
							$("#login_form").slideUp({
								direction : "down"
							}, 500);
						}, 200);

						setTimeout(function() {
							window.location.href = "./php/maps.php";
						}, 1000);

					} else if (correct_bt_nt_auth) {
						alert("Sorry you are only allowed to use Windows Application");

					} else {
						alert("Error Please Try Again");
						$("#submit_button").fadeIn("slow");
						document.getElementById("loading_image").style.display = "none";
						return false;
					}

				}

			}

			//on submit signin form call this function for AJAX loadings
			function ajax_signin() {
				if (!trys()) {
					return false;
				}

				//if(!subCheak()){
				//	alert("error!");
				//	return false;
				//}

				var username = document.forms["signin"]["username"].value;
				var password = document.forms["signin"]["password"].value;

				$("#submit_button").fadeOut("slow");
				document.getElementById("loading_image").style.display = "";
				//alert(username+">>>>>"+password);
				signin_ajax.open("POST", "./php/signin.php", true);
				signin_ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				signin_ajax.send("username=" + username + "&password=" + password);
				signin_ajax.onreadystatechange = ajax_return;

			}

			//ajax supported loging method --end

			//onload document slide up header and slide down login page section
			$(document).ready(function() {
				$('#loading').remove();
				$("#Sign_in").effect("slide", {
					direction : "down"
				}, 600);
				setTimeout(function() {
					$("#login_form").slideDown("slow");
				}, 600);

			});
			//onload document slide up header and slide down login page section --end
			function check_computer_number(obj) {
				var txt = new String(obj.value);
				if (txt.length == 6) {
					document.getElementById("error").setAttribute("src", "./media/images/logins/ok.ico");

					var new_value = "";
					for (letter in txt) {// use is a number to check number int validity
						new_value += txt[letter].toUpperCase();
					}
					obj.value = new_value;

				} else {
					document.getElementById("error").setAttribute("src", "./media/images/logins/no.ico");
				}
			}

			//check submition time computer_number value for validness
			function subCheak() {

				var input = document.forms["signin"]["username"];
				var error = document.getElementById("error");
				var computer_number = new String(input.value);

				if (computer_number.length != 7 || !isNaN(computer_number[computer_number.length - 1]) || isNaN(computer_number[1])) {
					error.setAttribute("src", "./media/images/logins/no.ico");
					return false;
				} else {
					for (chars in computer_number) {
						if (chars == (computer_number.length - 1))
							break;
						if (isNaN(computer_number[chars])) {
							error.setAttribute("src", "./media/images/logins/no.ico");
							return false;
						}
					}

					return true;
				}
			}

			//check submition time computer_number value for validness --end

		</script>
	</head>
	<!-- set webpage body background image use back*.jpg file notation resize image size with window size by "background-size:cover" style attribute -->
	<body id="body_first">

		<div class="row fixer">

			<div class="col-md-6 col-md-offset-3 text-center">
				<h3> Welcome to SLPA Vehicle Tracking System </h3>
			</div>
			<div class="row fixer">
				<div class="col-md-8 col-md-offset-2 effect8" style="background-color: #D9D9D9;" >
					<div class="row fixer">
						<br />

						<div class="col-md-10">
							<form class="form-horizontal" id="login_form" name="signin"  action="/php/signin.php" method="post" onsubmit="<!-- return ajax_signin() -->" style="display: none;">

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Computer Number</label>
									<div class="col-sm-10">
										<input class="form-control" onkeyup="check_computer_number(this)" type="text" id="login" name="username" required="required" placeholder="Computer number" autofocus  />
									</div>
								</div>
								<div class="form-group">
									<label for="inputPassword3" class="col-sm-2 control-label">Password</label>
									<div class="col-sm-10">
										<input class="form-control" type="password" name="password" id="password" required="required" placeholder="Password" />
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<button class="btn btn-primary" type="button" id="submit_button" name="submit" target="_self" onclick="ajax_signin()" >
											Sign in
											<img id="error" width="16" height="16" ></img>
										</button>

									</div>

								</div>
							</form>
							<img style="display: none" id="loading_image" src="./media/images/logins/login_loading.gif" />
						</div>

						<div class="col-md-2">
							<img src="./media/fav_icon/fav.png" id="fit11" />
						</div>

					</div>

				</div>

			</div>

		</div>

		<?php
		if($_POST["pass_stat"])
			print $_POST["pass_stat"];
		?>

		</div>
		<a
		style="position: absolute; bottom: 0px; float: right; color: #898989; font-size: 10pt;">V
		1.1 </a>
		<div style="position: absolute; bottom: 0px;  right: 0px; color: #898989; font-size: 10pt;">
			<a  rel="license" href="http://creativecommons.org/licenses/by-nc/3.0/deed.en_US"><img  alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nc/3.0/88x31.png" /></a>
			<span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">Server Program</span> by <a xmlns:cc="http://creativecommons.org/ns#" href="slpa.knnect.com" property="cc:attributionName" rel="cc:attributionURL">SysCall</a>
			is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc/3.0/deed.en_US">Creative Commons Attribution-NonCommercial 3.0 Unported License</a>.
			Based on a work at <a xmlns:dct="http://purl.org/dc/terms/" href="track.slpa.lk" rel="dct:source">track.slpa.lk</a>.Permissions beyond the scope of this license may be available at <a xmlns:cc="http://creativecommons.org/ns#" href="track.slpa.lk/cc" rel="cc:morePermissions">track.slpa.lk/cc</a>.
		</div>
		<a
		style="position: absolute; bottom: 0px; float: right; right: 0px; color: #898989; font-size: 10pt;"> <!-- &copy;-ḱß﹩◎ƒ☂ --> </a>

	</body>

</html>

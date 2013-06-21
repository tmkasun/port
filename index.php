<?php session_start();

if(isset($_SESSION["computer_number"])){
     header('Location: ./php/maps.php');
     
     
}



?>
<!DOCTYPE html>
<html lang="en-US">

<!-- 
 Message for developers:
 on submit return
 on press value check
 

 -->

<head>
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

<script type="text/javascript">
		//block tring after 3 attempt		
		var try_count = 0;
		function trys(){
			//alert("testing");
			if(try_count >2){
				alert("you have exceeded the maximum number of login attempts!");
				return false; 
				}
			else{
				try_count +=1;
				return true;
				}
			}			

		//block tring after 3 attempt end--
		
			//ajax supported loging method
			var signin_ajax = new XMLHttpRequest();
			function ajax_return(){
				
				var response = "";
				if(signin_ajax.readyState == 4 && signin_ajax.status == 200){
					response = signin_ajax.responseText;
					//alert(response);
					match_wrong_password = response.match("911");
					match_correct_password = response.match("correct_password_#145Akcode_214QW_code_");
                    correct_bt_nt_auth = response.match("notapp");
					//911 for wrong password code
					
				if(match_wrong_password){
					//alert("Wrong Password");
					//login and password are the id of username and password input tags :)
					document.getElementById("login").style.boxShadow = "0px 1px 5px 1px #F90000";
					document.getElementById("login").style.borderColor = "red";
					$( "#login" ).effect( "shake", 500);
					document.getElementById("password").style.borderColor = "red";
					document.getElementById("password").style.boxShadow = " 0px 1px 5px 1px #F90000";
					setTimeout(function(){$( "#password" ).effect( "shake", 500);},100);
					$("#submit_button").fadeIn("slow");
					document.getElementById("loading_image").style.display = "none";
					return false;
				}
				else if(match_correct_password){
					
					//alert("Correct Password");
					$("#fit11").fadeOut("slow");
					setTimeout(function(){$("#computer_number").effect( "drop",{direction: "right"}, 500);},200);
					$("#login").effect( "drop",{direction: "right"}, 200);
					$("#submit_button").fadeOut("slow");
					
					
					setTimeout(function(){$("#password").effect( "drop",{direction: "left"}, 500);},200);
					$("#pass").effect( "drop",{direction: "left"}, 500);
					
					setTimeout(function(){$("#Sign_in").slideUp( {direction: "up"}, 500);},800);
					setTimeout(function(){$("#login_form").slideUp({direction: "down"}, 500);},200);
					
					setTimeout(function(){window.location.href = "./php/maps.php";},1000);
					
					
					
					
				}
				else if(correct_bt_nt_auth){
                         alert("Sorry you are only allowed to use Windows Application");

                    }
				else{
					alert("Error Please Try Again");
					$("#submit_button").fadeIn("slow");
				document.getElementById("loading_image").style.display = "none";                
					return false;
				}
				
				}
				
				
			}

//on submit signin form call this function for AJAX loadings 
			function ajax_signin(){
				 if(!trys()){
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
				signin_ajax.open("POST","./php/signin.php",true);
				signin_ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				signin_ajax.send("username="+username+"&password="+password);
				signin_ajax.onreadystatechange = ajax_return;
				
			}
			//ajax supported loging method --end
			
			//onload document slide up header and slide down login page section
			$(document).ready(function(){
				$('#loading').remove();
				$("#Sign_in").effect("slide",{ direction: "down" },600);
				setTimeout(function(){$("#login_form").slideDown("slow");},600);
				
				});
			//onload document slide up header and slide down login page section --end
	function check_computer_number(obj){
		var txt =new String(obj.value);
		if(txt.length == 6 ){
			document.getElementById("error").setAttribute("src","./media/images/logins/ok.ico");
		
		var new_value = "";
		for(letter in txt){ // use is a number to check number int validity
			new_value += txt[letter].toUpperCase();
		}
		obj.value = new_value;
		
		
		}
		
		else {
			document.getElementById("error").setAttribute("src","./media/images/logins/no.ico");
		}
	}			
//check submition time computer_number value for validness 
	function subCheak(){
		
		var input = document.forms["signin"]["username"];
		var error = document.getElementById("error");
		var computer_number =new String(input.value);
		
		if(computer_number.length != 7 || !isNaN(computer_number[computer_number.length - 1]) || isNaN(computer_number[1])){
			error.setAttribute("src","./media/images/logins/no.ico");
			return false;
		}
		else{
			for(chars in computer_number){
				if(chars == (computer_number.length-1))
					break;
				if(isNaN(computer_number[chars])){
					error.setAttribute("src","./media/images/logins/no.ico");
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
<body id="body_first" style="background-image: url('');background-size:cover;-moz-background-size:cover;-webkit-background-size:cover;">
	<!-- div id="top_bar">
	<a style="position: relative;left: 5px;top: 10px;font-size:10pt;">Hello </a>
	
		<span style="position: relative;left: 5px;top: 10px;"><a>
	<?php
	error_reporting(E_PARSE); //should be removed
	if ($_SESSION['cname']){ //cheack weather user has loged into the system or not and disply a message
		header('Location : ./welcome.php');
		die();}
	else{
		print "Guest"."</a>";
	}
	?>
		</span>
	</font>
	</div -->

	<p align="center">
		<b><a style="font-size: 18pt; color: #FFBD12;">Welcome
				to SLPA Vehicle Tracking System</a> </b>
	</p>
	<div align="center" style="width: 50%">
		<br />

	</div>

	<div id="loging_div"
		style="position: relative; margin: 0px auto; text-align: center; width: 40%; box-shadow: 0px 10px 30px 1px #181B21; border-radius: 10px; padding-bottom: 5%;">

		<h1 id="Sign_in" style="display: none;">Sign in</h1>
		
<!-- Loging form tag(DOM) start -->
		<form id="login_form" name="signin" action="/php/signin.php" method="post"
			onsubmit="<!-- return ajax_signin() -->" style="display: none;">
			
			<!-- Computer number in SL Port has been used as unique identifier for user login -->
				<a id="computer_number" style="float: left;margin-left: 10pt;">Computer Number:</a> <img
					src="./media/fav_icon/fav.png" id="fit11"
					style="position: relative; float: right; resize: none; border: 0; overflow: hidden; width: 20%; height: 20%;margin-right: 10pt;" />
				<br />
				<br /> 
				 <input onkeyup="check_computer_number(this)" type="text" id="login"
					name="username" required="required"
					placeholder="Computer number" autofocus
					style="float: left; border: 1px groove #47A0D3; border-radius: 5px; margin: 0; padding: 5px;margin-left: 10pt;" />
				<br />
				<br /> 
				<a id="pass" style="float: left;margin-left: 10pt;">Password</a>
				<br />
				<br />
				<input type="password" name="password" id="password"
					required="required" placeholder="Password"
					style="float: left; border: 1px groove #47A0D3; border-radius: 5px; margin: 0; padding: 5px;margin-left: 10pt;" />
				<img id="loading_image"
					style="position: relative; float: right; display: none;"
					src="./media/images/logins/login_loading.gif" />
			
			<!-- input type = "submit"  style="visibility: hidden;"/ -->
			<button class="action bluebtn" type="button" id="submit_button" name="submit"
				class="def_button" target="_self" onclick="ajax_signin()" style="position: relative;float: left;">
				
				<img  id="error" style="text-align: right;" width="16" height="16"
					style="border: 0px;"></img> <span class="label">Sign in</span>
			</button>
		</form>
<!-- Loging form tag(DOM) End -->
		

		<?php if($_POST["pass_stat"]) print $_POST["pass_stat"];?>





	</div>
	<a
		style="position: absolute; bottom: 0px; float: right; color: #898989; font-size: 10pt;">V
		1.1 </a>
		<div style="position: absolute; bottom: 0px;  right: 0px; color: #898989; font-size: 10pt;">
		<a  rel="license" href="http://creativecommons.org/licenses/by-nc/3.0/deed.en_US"><img  alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nc/3.0/88x31.png" /></a>
		<span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">Server Program</span> by 
		<a xmlns:cc="http://creativecommons.org/ns#" href="slpa.knnect.com" property="cc:attributionName" rel="cc:attributionURL">SysCall</a> 
		is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc/3.0/deed.en_US">Creative Commons Attribution-NonCommercial 3.0 Unported License</a>.
		Based on a work at <a xmlns:dct="http://purl.org/dc/terms/" href="track.slpa.lk" rel="dct:source">track.slpa.lk</a>.Permissions beyond the scope of this license may be available at <a xmlns:cc="http://creativecommons.org/ns#" href="track.slpa.lk/cc" rel="cc:morePermissions">track.slpa.lk/cc</a>.
</div>
	<a
		style="position: absolute; bottom: 0px; float: right; right: 0px; color: #898989; font-size: 10pt;">
		<!-- &copy;-ḱß﹩◎ƒ☂ --> </a>


</body>

</html>

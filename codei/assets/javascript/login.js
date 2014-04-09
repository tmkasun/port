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

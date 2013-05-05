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



if(!isset($_SESSION["computer_number"])){
     header('Location: ../index.php');


}

//check the connection type, if running in local server import local setting else import other setting
//this is for compatibility from local and remote use
if($_SERVER[REMOTE_ADDR] == '127.0.0.1'){
     include_once('./mysql/local.php');
}
else
include_once('./mysql/remote.php');
print "<br/>";
?>
<!DOCTYPE html>
<html
     lang="en-US">
<!------------------------ Html Document definitions and page setups ------------------------>
<head>
<link rel="shortcut icon" href="../media/fav_icon/fav.png" />
<link rel="stylesheet" href="../css/jquery-ui.css" />
<title>Welcome to SLPA Vehicle Tracking System</title>
<meta name="keywords"
     content="srilanka port authority, SLPA,UOM,FIT,vehicle tracking system" />
<!--  SEO meta contents keywords -->
<meta name="author"
     content="University Of Moratuwa Faculty Of Information Technology" />
<meta name="description"
     content="Vehicle Tracking System for Srilanka Port Authority" />
<meta charset="UTF-8" />
<!------------------------ End ------------------------>




<style type="text/css">
.styled-button-8 {
	background: #25A6E1;
	background: -moz-linear-gradient(top, #25A6E1 0%, #188BC0 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #25A6E1),
		color-stop(100%, #188BC0) );
	background: -webkit-linear-gradient(top, #25A6E1 0%, #188BC0 100%);
	background: -o-linear-gradient(top, #25A6E1 0%, #188BC0 100%);
	background: -ms-linear-gradient(top, #25A6E1 0%, #188BC0 100%);
	background: linear-gradient(top, #25A6E1 0%, #188BC0 100%);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#25A6E1',
		endColorstr='#188BC0', GradientType=0 );
	padding: 8px 13px;
	color: #fff;
	font-family: 'Helvetica Neue', sans-serif;
	font-size: 14px;
	border-radius: 4px;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	border: 1px solid #1A87B9
}

.styled-button-10 {
	background: #5CCD00;
	background: -moz-linear-gradient(top, #5CCD00 0%, #4AA400 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #5CCD00),
		color-stop(100%, #4AA400) );
	background: -webkit-linear-gradient(top, #5CCD00 0%, #4AA400 100%);
	background: -o-linear-gradient(top, #5CCD00 0%, #4AA400 100%);
	background: -ms-linear-gradient(top, #5CCD00 0%, #4AA400 100%);
	background: linear-gradient(top, #5CCD00 0%, #4AA400 100%);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#5CCD00',
		endColorstr='#4AA400', GradientType=0 );
	padding: 10px 15px;
	color: #fff;
	font-family: 'Helvetica Neue', sans-serif;
	font-size: 16px;
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border: 1px solid #459A00
}
</style>











<!-- CSS style sheet for Leaflet API from online CDN -->




<link rel="stylesheet" href="../css/leaflet.css" />

<!------------------------------------------------ End ------------------------------------------------>

<!-------------------------- JavaScript file for Leaflet API from online CDN -------------------------->

<script src="../js/leaflet.js"></script>

<!------------------------------------------------ End ------------------------------------------------>

<!-------------------------- Javascript JQuery 1.8.3 API for animations and AJAX -------------------------->

<script src="../js/jquery-1.8.3.js"></script>

<script src="../js/jquery-ui-1.9.2.js"></script>

<!------------------------------------------------ End ------------------------------------------------>

<script type="text/javascript">

/* ------------------------------------ current browser (client) displaying imei numbers ------------------------------------ */

var currentVehicleList = []; //current browser (client) displaying imei numbers
//currentVehicleList.push("newVehicleimeiNumber");

/* ------------------------------------ end------------------------------------ */

/* ------------------------------------ Creating Map Layers Function ------------------------------------ */
  
 /*-------------------------- Diffrent tile servers URLs ---------------------*/
	
	//http://mt1.google.com/vt/x={x}&y={y}&z={z} //google maps tile server
	//http://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z} // another google hybrid map tile
	//  http://mt1.google.com/vt/lyrs=p&x={x}&y={y}&z={z} 
	//http://khm1.google.com/kh/v=49&x=[x]&y=[y]&z=[z]
	// http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png //openStreet maps tile server URL
	
	/*-------------------------- End ---------------------*/
 function foo(anything){
     alert(anything);

     }
 var map; // map object global variable
 
 tileServerList = {"cloudeMade":"http://{s}.tile.cloudmade.com/45b5101290e74ac29b24ff40cfd7e3ab/1/256/{z}/{x}/{y}.png","localhost":"http://track.slpa.lk/tiles/GoogleMaps/{z}/{x}/{y}.png","googleHybrid":"http://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}","googleMaps":"http://khm1.google.com/kh/v=49&x=[x]&y=[y]&z=[z]","openStreetMaps":"http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"};
 
function createMap(){
 	 
	map = L.map('map').setView([7.059000, 79.96119], 15);//7.059000 and 79.96119 is longitude(or) and latitude and 10 is the zoom level
	tiles = L.tileLayer("http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", { //set tile server URL for openStreet maps 
		maxZoom: 18,
        minZoom: 0,
        //zoomOffset: 1,
          //continuousWorld : true,
		//zoomReverse : true,
		attribution: 'Srilanka Port Authority'
			}).addTo(map);
	prime_mover_icon = L.icon({
		iconUrl : "../media/images/map/prime_mover_icon.png",
		//shadowUrl: '',

		iconSize: [48,48],
		//shadowSize: [0,0],
		iconAnchor: [22,94],
		popupAnchor: [-3,-76]
		});

	
	
}


/* ------------------------------------ end------------------------------------ */



/* ------------------------------------ Setup map layer @ documnt loading time ------------------------------------ */

var prime_mover_icon; 
//$(document).ready();

/* ------------------------------------ end------------------------------------ */



/* ------------------------------------ javaScript prime mover object ------------------------------------ */

function primeMover(serialNumber,imeiNumber,currentLat,currentLong,currentSatTime,vehicleNumber,markerObject){
	
	this.vehicleRegistrationNumber = vehicleNumber;
	this.imeiNumber = imeiNumber;
	this.serialNumber = serialNumber;
	this.currentLat = currentLat;
	this.currentLong = currentLong;
	this.currentSatTime = currentSatTime;
	this.marker = markerObject;
	this.foo = function foo(){ // or can use foo; and then declare function
		
		alert("Foo Funtion for futher use");

		};
	this.setVehicleSpeed = function (speed){
		this.speed = speed;
		};
	//alert("Prime Mover Object Constructor ");
	return this;


	
}


/* ------------------------------------ end------------------------------------ */


/* ------------------------------------ fetch data from maps_ajax.php using ajax------------------------------------ */

var jsonData;
$(document).ready(
					function (){

                        // create map layer in webpage
						createMap();
						
						/* ----------------------- AJAX orginal method for getting Json data ---------------------- */
						      
						$.ajax({
							url:"maps_ajax.php",
							dataType : "json",
							type : "GET",
							data : ""
							}
								).done(
										function (jsonObject){
											//alert(jsonObject);
											jsonData = jsonObject;//assign to jsonData global variable to wider accecebility
											for(items in jsonData){
												/* debug code to check recevied values from ajax 
												alert(" Serial "+ jsonData[items]["serial"]+" IMEI "+ jsonData[items]["imei"]+" Latitude "+ jsonData[items]["latitude"]+" longitude "+ jsonData[items]["longitude"]+" Sat_time "+ jsonData[items]["sat_time"]);
												*/

												/* ------------------------------------- Prevent addnig already exsisted vehicle to the map (no overlapping tow vehicles)-------------------------------------*/
												if(jsonData[items]["imei"] in currentVehicleList){
													//alert("Already In The Vehicle List");
													currentVehicleList[jsonData[items]["imei"]].marker.setLatLng([parseFloat(jsonData[items]["latitude"]),parseFloat(jsonData[items]["longitude"])]);
													alert("New Lat Long has been set");

													break;
													}
												
												var imeiNumberAsKey = String(jsonData[items]["imei"]);
												currentVehicleList[imeiNumberAsKey] = new primeMover(jsonData[items]["serial"], jsonData[items]["imei"], jsonData[items]["latitude"], jsonData[items]["longitude"], jsonData[items]["sat_time"],"noDataAvailable","NoMarker");
												//alert(currentVehicleList[imeiNumberAsKey].imeiNumber);
												//interMidVar = parseFloat(jsonData[items]["latitude"]);
												
												message = '<?php if($_SESSION["admin"] == TRUE) echo "Administrator Features";else echo "Normal User Features";  ?>';//Display administrator elements 
												currentVehicleList[imeiNumberAsKey].marker = L.marker([parseFloat(jsonData[items]["latitude"]),parseFloat(jsonData[items]["longitude"])],{icon:prime_mover_icon}).addTo(map);
												popupCSSdisplay = "<b>GPS/GPRS Device imei Number: <font style='color:red;'>"+jsonData[items]["imei"]+"</font></b><br/>Current GPS Coordinates<ul><li>Latitude: "+ jsonData[items]["latitude"]+"</li><li>Longitude: "+jsonData[items]["longitude"]+"</li></ul>"+"<font style='color:blue'>"+message+"</font>";
												currentVehicleList[imeiNumberAsKey].marker.bindPopup(popupCSSdisplay);//.openPopup() for open popup at the begining
												setInterval(ajaxCheck, 1000);

												
														}
											
											}
										
										
										);
						
						}
					/*---------------------------------- End ----------------------------------*/
		
		);
/*---------------------------------- End ----------------------------------*/
 
/*---------------------------------- ajaxCheck method----------------------------------*/

function ajaxCheck(){
						
						/* ----------------------- AJAX orginal method for getting Json data ---------------------- */
						
						$.ajax({
							url:"maps_ajax.php",
							dataType : "json",
							type : "GET",
							data : ""
							}
								).done(
										function (jsonObject){
                                                       
											jsonData = jsonObject;
											for(items in jsonData){
												/* debug code to check recevied values from ajax 
												alert(" Serial "+ jsonData[items]["serial"]+" IMEI "+ jsonData[items]["imei"]+" Latitude "+ jsonData[items]["latitude"]+" longitude "+ jsonData[items]["longitude"]+" Sat_time "+ jsonData[items]["sat_time"]);
												*/

												/* ------------------------------------- Prevent addnig already exsisted vehicle to the map (no overlapping tow vehicles)-------------------------------------*/
												if(jsonData[items]["imei"] in currentVehicleList){
													//alert("Already In The Vehicle List"+jsonData[items]["imei"]);
													currentVehicleList[jsonData[items]["imei"]].marker.setLatLng([parseFloat(jsonData[items]["latitude"]),parseFloat(jsonData[items]["longitude"])]);
													//alert("New Lat Long has been set");
													message = '<?php if($_SESSION["admin"] == TRUE) echo "Administrator Features";else echo "Normal User Features";  ?>';
													popupCSSdisplay = "<b>GPS/GPRS Device imei Number: <font style='color:red;'>"+jsonData[items]["imei"]+"</font></b><br/>Current GPS Coordinates<ul><li>Latitude: "+ jsonData[items]["latitude"]+"</li><li>Longitude: "+jsonData[items]["longitude"]+"</li></ul><br/>"+"<font style='color:blue'>"+message+"</font>";
													currentVehicleList[jsonData[items]["imei"]].marker._popup.setContent(popupCSSdisplay);

													continue;
													}
												/* Add new vehicle to map if it is not in the currentVehicleList list*/
												var imeiNumberAsKey = String(jsonData[items]["imei"]);
												currentVehicleList[imeiNumberAsKey] = new primeMover(jsonData[items]["serial"], jsonData[items]["imei"], jsonData[items]["latitude"], jsonData[items]["longitude"], jsonData[items]["sat_time"],"noDataAvailable","NoMarker");
												//alert(currentVehicleList[imeiNumberAsKey].imeiNumber);
												//interMidVar = parseFloat(jsonData[items]["latitude"]);
												

												currentVehicleList[imeiNumberAsKey].marker = L.marker([parseFloat(jsonData[items]["latitude"]),parseFloat(jsonData[items]["longitude"])],{icon:prime_mover_icon}).addTo(map);
												currentVehicleList[imeiNumberAsKey].marker.bindPopup("<b>GPS/GPRS Device imei Number</b><br>Vehicle Registration Number");//.openPopup() for open popup at the begining
												//alert("Vehicle Add Compleated");
														}
											
											}
										
										
										);
						
						}
/*---------------------------------- End ----------------------------------*/

 
 
 
/*---------------------------------- Foo methods ----------------------------------*/
function approveVehicles(){
	
$.ajax({
 url : "./features/vehicleAuthenticationStatus.php",
                
} ).done(
          function (returnHttpObject){
            //alert(returnHttpObject);
            document.getElementById("commonMessageBoxResultBox").innerHTML = returnHttpObject;
            $("#commonMessageBox").fadeIn("slow");

               });

	     
}



function showVehicleHistory() {
	//alert("Not implimented"); //for check function call working
	$("#leftSideSlidePane").show("slide",{direction:"left"});

     $("#leftSideSlidePaneResultBox").html(loadingImage).load("./features/retrieveVehicleList.php");
     
}
function changeMapTileServer(ServerName){
     switch (ServerName) {
	case "googleMap":
	    tiles.setUrl("http://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}");
	    break;

    case "OSM":
        tiles.setUrl("http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png");
    	//map._resetView(map.getCenter(), map.getZoom(), true);
    	//$("#map").hide("slide",{direction:"left"});
        break;

    case "localGoogleMaps":
     tiles.setUrl("http://track.slpa.lk/tiles/GoogleMaps/{z}/{x}/{y}.png");
        break;      
    case "localVirtualEarth":
     
        tiles.setUrl("http://track.slpa.lk/tiles/OSM_sat_tiles/{z}/{x}/{y}.png");
        break;

    case "OpenStreetMap":
            tiles.setUrl("http://track.slpa.lk/tiles/OpenStreetMap/{z}/{x}/{y}.png");
        break;  

          }
}

// gloable variable url for loading imege in string

var loadingImage = '<img alt="Loading......" src="../media/images/icons/loading.gif">';

function changeMap() {
	//alert("<font color = 'red'>call get_administrators function</font>"); //for check function call working
    $("#leftSideSlidePane").show("slide",{direction:"left"}); 
     
    $("#leftSideSlidePaneResultBox").html(loadingImage).load("./features/loadMapTypes.php");
}
/*---------------------------------- End ----------------------------------*/

/*---------------------------------- leftSidePaneImageOnClick ----------------------------------*/
 var currentDataPickerVehicleImei = 0;
 
function leftSidePaneImageOnClick(thisVehicle){

	$( "#datePicker" ).datepicker({ dateFormat: "yy-mm-dd" });
    $("#commonMessageBox").fadeIn("slow");
    $( "#datePicker" ).fadeIn("fast");
    //alert(thisVehicle.id);
    currentDataPickerVehicleImei = thisVehicle.id;
    $('#leftSideSlidePane').hide('slide',{direction:'left'});
    return 0;
    //[7.060190,79.96199],[7.072187,79.96799]
    //var polyLine = L.polyline([[7.072487,79.96699]],{color:"red"}).addLatLng([7.060015,79.96121]).addTo(map);
    
}

/*---------------------------------- End ----------------------------------*/
 
/*---------------------------------- getVehiclePath ----------------------------------*/
function getVehiclePath(selectedDateObject) {
	 //alert(selectedDateObject);
     var year = selectedDateObject.getFullYear();
     var month = String(selectedDateObject.getUTCMonth()+1);
     var date = String(selectedDateObject.getDate());
     if(month.length<2)
         month = "0"+month;
     if (date.length <2)
         date = "0"+date;
     //alert(year+">>>"+month+">>>"+date+">>>>>>"+currentDataPickerVehicleImei);
     
	$.ajax({
        type : "GET",
        url: "./features/getVehiclePath.php",
        dataType : "JSON",
        data : {"deviceImeiNumber":currentDataPickerVehicleImei,"year":year,"month":month,"date":date}

        }
            ).done(function(jsonObject){
                //alert(jsonObject[0]["latitude"]);
                //return 0;
                var startingPointLatLng = new L.LatLng(jsonObject[0]["latitude"],jsonObject[0]["longitude"]);
                var polyLineDistanceInMeters = 0;
                var polyLine = L.polyline([],{color:"red"});//.addLatLng([7.060015,79.96121]).addTo(map);
                var currentLatLng = startingPointLatLng;
                for ( var sections in jsonObject) {
                		for ( var pass in sections) {
                    	currentLongitude = jsonObject[sections]["longitude"];
                        currentLatitude = jsonObject[sections]["latitude"];
                        var nextLatLng = new L.LatLng(currentLatitude,currentLongitude); 
                        polyLineDistanceInMeters += currentLatLng.distanceTo(nextLatLng);
                        //alert(polyLineDistanceInMeters);         
                        currentLatLng = nextLatLng;

                        polyLine.addLatLng([currentLatitude,currentLongitude]);
                              
					}
					
				}
                    polyLine.addTo(map);
                    polyLine.on("click",onClickPolyLinePopupOpenner);
                    //var polyLinePopUp
                    var polyLinePopupContent = "<a style = 'color:red'>Total Distance = "+polyLineDistanceInMeters.toFixed(1) +"(in meters)("+(polyLineDistanceInMeters/1000).toFixed(1)+"Km)</a>";
                    polyLine.bindPopup(polyLinePopupContent).openPopup();
                    L.circle(startingPointLatLng,50,{color:"green",stroke:true,fillColor:"red",weight:2}).addTo(map).bindPopup("Starting Point @ "+jsonObject[0]["sat_time"]+" Time").openPopup();
                });
    //var polyLine = L.polyline([,]).addTo(map);
    $('#commonMessageBox').fadeOut('slow');
    $('#datePicker').fadeOut('slow');
}



/*---------------------------------- End ----------------------------------*/

function onClickPolyLinePopupOpenner(mouseEventObject){
     alert(mouseEventObject.latlng);


	     
}
</script>
</head>
<body
     style="background-image: url('../media/images/backgrounds/map_background3.jpg'); background-size: cover; -moz-background-size: cover; -webkit-background-size: cover; margin: 0; padding: 0;">

     <div id="functionButtons"
          style="position: relative; width: 80%; margin-left: auto; margin-right: auto; background-color: maroon; background: rgba(20, 15, 1, 0.9); border-radius: 8px; box-shadow: 0px 0px 20px 1px #001221;">

          <button id="approve_vehicles_to_map"
               onclick="approveVehicles()" class="styled-button-10"
               style="position: relative; margin-left: 40; margin-right: 40%;">Add
               Vehicles to map</button>

          <button id="loguot_button" class="styled-button-8"
               style="position: relative; float: right; margin: 0; padding: 0;"
               onclick="window.location.href = './logout.php' ">Logout</button>


          <button id="showVehicleHistory" class="styled-button-8"
               onclick="showVehicleHistory()">Show Vehicle History</button>
          <button id="get_administrators" class="styled-button-8"
               onclick="changeMap()">Change map type</button>

          <div id="ajax_result_div" style="position: relative;"></div>


     </div>
     <div id="leftSideSlidePane"
          style="position: fixed; float: left; height: 91%; width: 10%; background-color: red; z-index: 2; background: rgba(22, 14, 20, 0.9); border-radius: 12px; box-shadow: 0px 0px 20px 5px #000000; display: none;">
          <img
               onclick="$('#leftSideSlidePane').hide('slide',{direction:'left'})"
               alt="Close" src="../media/images/logins/no.ico"
               style="position: relative; float: right; top: 0px;" /> <br />
          <br /> <br />
          <div id="leftSideSlidePaneResultBox"
               style="overflow: auto; height: 100%;"></div>

     </div>

     <!-- Open street maps via leaflet javascript framework-->
     <div id="map"
          style="position: relative; width: 95%; height: 88%; float: left; margin-left: 3%; margin-right: 3%; background: rgba(123, 98, 159, 0.9); border-radius: 15px; box-shadow: 0px 0px 20px 5px #000000;">
          OSM Layer



          <div id="commonMessageBox"
               style="position: relative; z-index: 4; width: 50%; height: 50%; margin-left: auto; margin-right: auto; background: rgba(22, 14, 20, 0.9); border-radius: 12px; box-shadow: 0px 0px 20px 5px #000000; display: none;">
               <img onclick="$('#commonMessageBox').fadeOut('slow')"
                    alt="Close" src="../media/images/logins/no.ico"
                    style="position: relative; float: right; top: 0px;" />
               <br /> <br /> <br />
               <div id="commonMessageBoxResultBox"
                    style="overflow: auto; height: 75%; position: relative; width: auto;">

               </div>

               <div id="datePicker"
                    style="position: relative; margin-left: auto; margin-right: auto; width: 40%; display: none;">
                    <button
                         onclick="getVehiclePath($('#datePicker').datepicker('getDate'))">Show
                         Path</button>
               </div>

          </div>
     </div>

     <script type="text/javascript">
		

	
	
	</script>
     <!-- Open street maps via leaflet javascript framework  end -->

</body>

</html>



























<!-- ---------------------------------------------------- Backup codes and grave yard for recovery ------------------------------------------------------>

<!-- 

<?php /*



//datepicker



          <select class="year">
<?php 
for ($i = 2000; $i < 2099; $i++) {
     ?>
     
     <option ><?php print $i+1;?></option>
     
     
     
     <?php 
}
?>
     
          </select>
          <select class="month">
          <option >January</option>
          <option >February</option>
          <option >March</option>
          <option >April</option>
          <option >May</option>
          <option >June</option>
          <option >July</option>
          <option >Augest</option>
          <option >September</option>
          <option >Octomber</option>
          <option >November</option>
          <option >December</option>
          </select>
          <select class="date">
<?php 
for ($i = 0; $i < 31; $i++) {
     ?>
     
     <option ><?php print $i+1;?></option>
     
     
     
     <?php 
}
?>
          
          </select>
   
   
   <br/>       
   <br/>
   <br/>
   <br/>       
          <select class="year">
<?php 
for ($i = 2000; $i < 2099; $i++) {
     ?>
     
     <option ><?php print $i+1;?></option>
     
     
     
     <?php 
}
?>
     
          </select>
          <select class="month">
          <option >January</option>
          <option >February</option>
          <option >March</option>
          <option >April</option>
          <option >May</option>
          <option >June</option>
          <option >July</option>
          <option >Augest</option>
          <option >September</option>
          <option >Octomber</option>
          <option >November</option>
          <option >December</option>
          </select>
          <select class="date">
<?php 
for ($i = 0; $i < 31; $i++) {
     ?>
     
     <option ><?php print $i+1;?></option>
     
     
     
     <?php 
}
?>
          
          </select>
          


//end----------------------------------------------













	    //-----------------------------------------------------------------------
	   
	    //-----------------------------------------------------------------------
	                                       
	                  //the script to call to get data          
	                     
	                                       
	                
	        //on recieve of reply
	      
	    	  
	      //get id
	                //get name
	        //--------------------------------------------------------------------
	        // 3) Update html content
	        //--------------------------------------------------------------------
	        
	        //recommend reading up on jquery selectors they are awesome 
	        // http://api.jquery.com/category/selectors
	    
	  


	//jquery ajax end --

	// ------------------this is a backup code for falier use older version of AJAX XHR ------------------
	//alert("call Get_coordinates function"); //for check function call working
	/* 
	ajax_coordinates_function();
	setInterval(ajax_coordinates_function, 1000);
	}
function ajax_coordinates_function(){
	function_call_count+=1;
	ajax_coordinates.onreadystatechange = function(){
		
	        if(ajax_coordinates.readyState == 4 & ajax_coordinates.status == 200){
	            document.getElementById("ajax_result_div").innerHTML = "<a style ='color: red;'>AJAX Load Count = "+function_call_count+"</a></br>"+ajax_coordinates[0];
	     			 }
	    };
	    ajax_coordinates.open("GET","maps_ajax.php",true);
		ajax_coordinates.send();
	*/

/* ----------------------- direct getJSON method in JQuery for json responseces---------------------- */
						 
						/*
						$.getJSON(
								"maps_ajax.php",
								function (jsonObject){
									jsonData = jsonObject;
									alert(data["imei"]);
									

									}
								);
						*/
						/*---------------------------------- End ----------------------------------*/
						
?>
 -->

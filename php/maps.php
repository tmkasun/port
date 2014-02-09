<?php session_start();

//session start to identify login users and etc

/*
 * Message for developers:
 *#code1 = for Srilanka Port Authority
 *#code2 = SLPA
 *
 *
 *
 * */



if(!isset($_SESSION["computer_number"])){
     header('Location: ../index.php');


}

//check the connection type, if running in local server import local setting else import other setting
//this is for compatibility from local and remote use

include_once('./mysql/local.php');
include_once("./features/googleAnalyticsTracking.php")
//print "<br/>";
?>
<!DOCTYPE html>
<html
     lang="en-US">
<!------------------------ Html Document definitions and page setups ------------------------>
<head>
<link rel="shortcut icon" href="../media/fav_icon/fav.png" />

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
.specialDate { background-color: #6F0 !important; }
</style>

<style type="text/css">
.styled-button-8 {
	cursor:pointer;
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
	cursor:pointer;
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



<!-- JQuery ui styles -->
<link rel="stylesheet" href="../css/jquery-ui.css" />

<!-- CSS style sheet for Leaflet API from online CDN -->
<link rel="stylesheet" href="../css/leaflet.css" />
<link rel="stylesheet" href="../css/leaflet.label.css" />


<!-- CSS style sheet for date and time picker -->
<link rel="stylesheet" href="../css/jquery-ui-timepicker-addon.css" />

<!------------------------------------------------ End ------------------------------------------------>

<!-------------------------- JavaScript file for Leaflet API from online CDN -------------------------->
<!-- local file -->
<script src="../js/leaflet.js"></script>
<script src="../js/leaflet.label.js"></script>
<!-- Load file from Leaflet CDN -->
<!-- <script src="http://cdn.leafletjs.com/leaflet-0.6.4/leaflet.js"></script> -->




<!-- Documentation https://github.com/openplans/Leaflet.AnimatedMarker -->
<script src="../js/AnimatedMarker.js"></script>

<!-- Rotate marker (vehicle) according to its recevied heading -->
<script src="../js/Marker.Rotate.js"></script>


<!------------------------------------------------ End ------------------------------------------------>

<!-------------------------- Javascript JQuery 1.8.3 API for animations and AJAX -------------------------->

<script src="../js/jquery-1.8.3.js"></script>

<script src="../js/jquery-ui-1.9.2.js"></script>

<script src="../js/jquery-ui-timepicker-addon.js"></script>
<!------------------------------------------------ End ------------------------------------------------>

		<link rel="stylesheet" href="../css/uikit.min.css" />

		<script src="../js/uikit.min.js"></script>
		
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

<script type="text/javascript">

/* ------------------------------------ current browser (client) displaying imei numbers ------------------------------------ */

var currentVehicleList = []; //current browser (client) displaying imei numbers
var totalNumberOfPrimovers = 0;
var currentOnlinePrimovers = 0;
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
 
 tileServerList = {"mapbox":"http://api.tiles.mapbox.com/v2/sysccall.map-wuiel8n4/{z}/{x}/{y}.png","cloudeMade":"http://{s}.tile.cloudmade.com/45b5101290e74ac29b24ff40cfd7e3ab/1/256/{z}/{x}/{y}.png","localhost":"http://slpa.local.knnect.com/tiles/GoogleMaps/{z}/{x}/{y}.png","googleHybrid":"http://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}","googleMaps":"http://khm1.google.com/kh/v=49&x=[x]&y=[y]&z=[z]","openStreetMaps":"http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"};
 
function createMap(){
 	 
	map = L.map('map').setView([6.934846, 79.851980], 15);//7.059000 and 79.96119 is longitude(or) and latitude and 10 is the zoom level
	tiles = L.tileLayer(tileServerList["openStreetMaps"], { //set tile server URL for openStreet maps 
		maxZoom: 18,
        minZoom: 0,
        //zoomOffset: 1,
          //continuousWorld : true,
		//zoomReverse : true,
		attribution: 'Srilanka Port Authority'
			}).addTo(map);
	prime_mover_icon_offline = L.icon({
		iconUrl : "../media/images/map/prime_mover_icon_offline.png",
		//shadowUrl: '',

		iconSize: [24,24],
		//shadowSize: [0,0],
		iconAnchor: [+12,+12],
		popupAnchor: [-2,-5] //[-3,-76]
		});

	prime_mover_icon_online = L.icon({
		iconUrl : "../media/images/map/prime_mover_icon_online.png",
		//shadowUrl: '',

		iconSize: [24,24],
		//shadowSize: [0,0],
		iconAnchor: [+12,+12],
		popupAnchor: [-2,-5] //[-3,-76]
		});
	
}


/* ------------------------------------ end------------------------------------ */



/* ------------------------------------ Setup map layer @ documnt loading time ------------------------------------ */

var prime_mover_icon_offline; 
var prime_mover_icon_online;
//$(document).ready();

/* ------------------------------------ end------------------------------------ */



/* ------------------------------------ javaScript prime mover object ------------------------------------ */

function primeMover(imeiNumber,currentLat,currentLong,currentSatTime,vehicleNumber,markerObject,currentSpeed){
	
	this.vehicleRegistrationNumber = vehicleNumber;
	this.imeiNumber = imeiNumber;
	this.currentLat = currentLat;
	this.currentLong = currentLong;
	this.currentSatTime = currentSatTime;
     this.currentSpeed = currentSpeed;
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
						//$("#functionButtons").toggle( { effect: "slide", direction: "up" ,distance:30});                    
                      
                        // create map layer in webpage
						createMap();
						$( "#commonMessageBox" ).draggable({
							cancel: "#commonMessageBox > div"
						});
						
						//Fired changeIconSize method when the map zoom changes. to change the marker size accordingly
						//map.on('zoomend', changeIconSize);
						
						/* ----------------------- AJAX orginal method for getting Json data ---------------------- */
						      
						$.ajax({
							url:"maps_ajax.php",
							dataType : "json",
							type : "POST",
							data : {"firstTime":"yes"}
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
													currentVehicleList[jsonData[items]["imei"]].marker.setLatLng([parseFloat(jsonData[items]["latitude"]),parseFloat(jsonData[items]["longitude"])]);
													currentVehicleList[jsonData[items]["imei"]].marker.setIconAngle(parseInt(jsonData[items]["bearing"]));
													break;
													}
												
												var imeiNumberAsKey = String(jsonData[items]["imei"]);
												currentVehicleList[imeiNumberAsKey] = new primeMover(jsonData[items]["imei"], jsonData[items]["latitude"], jsonData[items]["longitude"], jsonData[items]["sat_time"],"noDataAvailable","NoMarker",jsonData[items]["speed"]);
												//alert(currentVehicleList[imeiNumberAsKey].imeiNumber);
												//interMidVar = parseFloat(jsonData[items]["latitude"]);
												
												message = '<?php if($_SESSION["admin"] == TRUE) echo "Administrator Features";else echo "Normal User Features";  ?>';//Display administrator elements 
												currentVehicleList[imeiNumberAsKey].marker = L.marker([parseFloat(jsonData[items]["latitude"]),parseFloat(jsonData[items]["longitude"])],{icon:prime_mover_icon_offline,iconAngle: parseInt(jsonData[items]["bearing"])}).addTo(map);
												//popupCSSdisplay = "<b>GPS/GPRS Device imei Number: <font style='color:red;'>"+jsonData[items]["imei"]+"</font></b><br/>Current GPS Coordinates<ul><li>Latitude: "+ jsonData[items]["latitude"]+"</li><li>Longitude: "+jsonData[items]["longitude"]+"</li></ul>"+"<font style='color:blue'>"+message+"</font>";
												popupCSSdisplay = "<b>GPS/GPRS Device imei Number: <font style='color:red;'>"
                                                                      +jsonData[items]["imei"]+"</font></b><br/>Current GPS Coordinates<ul><li>Latitude: "+ jsonData[items]["latitude"]+"</li><li>Longitude: "+jsonData[items]["longitude"]+"</li></ul><br/>"
                                                                      +"<font style='color:blue'>"+message+"</font>"
                                                                      +"<br/> Current speed is <span style='color:green'> "+currentVehicleList[jsonData[items]["imei"]].currentSpeed+"</span>Kmph";

                                                            
                                                            currentVehicleList[imeiNumberAsKey].marker.bindPopup(popupCSSdisplay);//.openPopup() for open popup at the begining
												totalNumberOfPrimovers +=1;
													
														}
										//	map.setView([parseFloat(jsonData[items]["latitude"]),parseFloat(jsonData[items]["longitude"])], 15);
                                            $("#totalRegisterdPrimovers").html(totalNumberOfPrimovers); 
                                            
	                                        setInterval(ajaxCheck, 1000);
                                                       
											}
										
										
										);
						
						}
					/*---------------------------------- End ----------------------------------*/
		
		);
/*---------------------------------- End ----------------------------------*/
 
/*---------------------------------- ajaxCheck method----------------------------------*/

function ajaxCheck(){   
	
     					$("#serverStatusImage").attr("src","../media/images/icons/serverStatus/status_red.png");
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
                                            currentOnlinePrimovers = 0;
                                            $("#serverStatusImage").attr("src","../media/images/icons/serverStatus/status_green.png");
     										jsonData = jsonObject;
                                            offlinePrimovers = currentVehicleList;
                                            latestRecivedImeiNumbers = [];
											for(items in jsonData){
												currentOnlinePrimovers +=1;
												latestRecivedImeiNumbers.push(jsonData[items]["imei"]);  
												/* debug code to check recevied values from ajax 
												alert(" Serial "+ jsonData[items]["serial"]+" IMEI "+ jsonData[items]["imei"]+" Latitude "+ jsonData[items]["latitude"]+" longitude "+ jsonData[items]["longitude"]+" Sat_time "+ jsonData[items]["sat_time"]);
												*/

												/* ------------------------------------- Prevent addnig already exsisted vehicle to the map (no overlapping tow vehicles)-------------------------------------*/
												if(jsonData[items]["imei"] in currentVehicleList){
													//alert("Already In The Vehicle List"+jsonData[items]["imei"]);
	                                                currentVehicleList[jsonData[items]["imei"]].marker.setLatLng([parseFloat(jsonData[items]["latitude"]),parseFloat(jsonData[items]["longitude"])]);
	                                                currentVehicleList[jsonData[items]["imei"]].marker.setIconAngle(parseInt(jsonData[items]["bearing"]));
													currentVehicleList[jsonData[items]["imei"]].currentSpeed =  jsonData[items]["speed"];     
													currentVehicleList[jsonData[items]["imei"]].marker.setIcon(prime_mover_icon_online);                    
													//alert("New Lat Long has been set");
													message = '<?php if($_SESSION["admin"] == TRUE) echo "Administrator Features";else echo "Normal User Features";  ?>';
													popupCSSdisplay = "<b>GPS/GPRS Device imei Number: <font style='color:red;'>"
                                                                      +jsonData[items]["imei"]+"</font></b><br/>Current GPS Coordinates<ul><li>Latitude: "+ jsonData[items]["latitude"]+"</li><li>Longitude: "+jsonData[items]["longitude"]+"</li></ul><br/>"
                                                                      +"<font style='color:blue'>"+message+"</font>"
                                                                      +"<br/> Current speed is <span style='color:green'> "+currentVehicleList[jsonData[items]["imei"]].currentSpeed+"</span>Kmph";


                    													currentVehicleList[jsonData[items]["imei"]].marker._popup.setContent(popupCSSdisplay);
													continue;
													}
												/* Add new vehicle to map if it is not in the currentVehicleList list*/
												var imeiNumberAsKey = String(jsonData[items]["imei"]);
												currentVehicleList[imeiNumberAsKey] = new primeMover(jsonData[items]["imei"], jsonData[items]["latitude"], jsonData[items]["longitude"], jsonData[items]["sat_time"],"noDataAvailable","NoMarker",jsonData[items]["speed"]);
												//alert(currentVehicleList[imeiNumberAsKey].imeiNumber);
												//interMidVar = parseFloat(jsonData[items]["latitude"]);
												

												currentVehicleList[imeiNumberAsKey].marker = L.marker([parseFloat(jsonData[items]["latitude"]),parseFloat(jsonData[items]["longitude"])],{icon:prime_mover_icon_online,iconAngle: parseInt(jsonData[items]["bearing"])}).addTo(map);
												currentVehicleList[imeiNumberAsKey].marker.bindPopup("<b>GPS/GPRS Device imei Number</b><br>Vehicle Registration Number");//.openPopup() for open popup at the begining
												//alert("Vehicle Add Compleated");
												
														}
														for(imeiNumberIndex in currentVehicleList){
															if($.inArray(currentVehicleList[imeiNumberIndex].imeiNumber,latestRecivedImeiNumbers) == -1){
																//alert("This imei"+currentVehicleList[imeiNumberIndex].imeiNumber+"not active");
																currentVehicleList[imeiNumberIndex].marker.setIcon(prime_mover_icon_offline);
																
															} 
														}
											$("#currentOnlinePrimovers").html(currentOnlinePrimovers);
                                             

											
											}
										
										
										);
						
						}
/*---------------------------------- End ----------------------------------*/

 
 
 
/*---------------------------------- Foo methods ----------------------------------*/
function approveVehicles(){
	$("#vehicle_history_div").hide(); ///need to replace with commen clear function
	
$.ajax({
 url : "./features/vehicleAuthenticationStatus.php",
                
} ).done(
          function (returnHttpObject){
            //alert(returnHttpObject);
            $("#commonMessageBoxResultBox").html("");
            document.getElementById("commonMessageBoxResultBox").innerHTML = returnHttpObject;
            $("#commonMessageBox").fadeIn("slow");

               });

	     
}



function showVehicleHistory() {
	
	$("#vehicle_history_div").hide();
	
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
     tiles.setUrl("http://slpa.local.knnect.com/tiles/GoogleMaps/{z}/{x}/{y}.png");
        break;      
    case "localVirtualEarth":
     
        tiles.setUrl("http://slpa.local.knnect.com/tiles/OSM_sat_tiles/{z}/{x}/{y}.png");
        break;

    case "OpenStreetMap":
            tiles.setUrl("http://slpa.local.knnect.com/tiles/OpenStreetMap/{z}/{x}/{y}.png");
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
 var datesArray=['18/09/2013']
function leftSidePaneImageOnClick(thisVehicle){
	
	$( "#commonMessageBoxResultBox").html("");
	$( "#commonMessageBoxResultBox").hide();
	//$( "#commonMessageBoxResultBox").removeProp("class");
	imei = $(thisVehicle).attr('imei');
	$.ajax({
		type : "POST",
		url: "./features/detailedVehicleHistroy.php",
		dataType : "JSON",
		data : { imei: imei}

		}
		).done(function(jsonObject){
		ul = $("<ul>");
		for ( var date in jsonObject) {
		//alert( "Data Loaded: " + jsonObject[date].dates );
		li = $("<li>");
		li.html(jsonObject[date].dates);
		$(ul).append(li);
		}
		$("#histroy_dates").html("");
		$("#histroy_dates").append(ul);

		} 	
);		


	$("#vehicle_history_div").fadeIn("slow");
	$( "#commonMessageBoxResultBox").fadeIn("slow");
	$("#commonMessageBox").fadeIn("slow");
	init_date_time(thisVehicle);
	

    
}
var firstTime = true;
function init_date_time (thisVehicle) {
  		$('#datePicker').fadeIn('slow');


		$("#time_picker_1").timepicker({
			
		});
		$(".ui-datepicker-title:eq(1)").html("End time");
		$("#time_picker_2").timepicker({
		
		});
		
		$(".ui-datepicker-title:eq(3)").html("Starting time");
		
		$("#datePicker").datepicker({
			dateFormat: "yy-mm-dd",
		});
		
		/*
		 <button
		 onclick="getVehiclePath($('#commonMessageBoxResultBox').datepicker('getDate'))">Show
		 Path</button>

		 */

		
		$("<button/>", {
			onClick : "getVehiclePath($('#datePicker').datetimepicker('getDate'),$('#time_picker_2').timepicker('getDate').val(),$('#time_picker_1').timepicker('getDate').val())",
			text : "Show History"
		}).replaceWith("#datePicker button");
		
		/* FIXME bad method to use firstTime flag need to remove this tempory fix */
		if (firstTime){
		$("<button/>", {
			onClick : "getVehiclePath($('#datePicker').datetimepicker('getDate'),$('#time_picker_2').timepicker('getDate').val(),$('#time_picker_1').timepicker('getDate').val())",
			text : "Show History"
		}).appendTo("#datePicker");
		firstTime = false;
		}

		currentDataPickerVehicleImei = $(thisVehicle).attr('imei');
		$('#leftSideSlidePane').hide('slide', {
			direction : 'left'
		});
		return 0;
		//[7.060190,79.96199],[7.072187,79.96799]
		//var polyLine = L.polyline([[7.072487,79.96699]],{color:"red"}).addLatLng([7.060015,79.96121]).addTo(map);

}


/*---------------------------------- End ----------------------------------*/
 
/*---------------------------------- getVehiclePath ----------------------------------*/
function getVehiclePath(selectedDateObject,start,end) {
	
	//alert(start+end+selectedDateObject);
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
        data : {"deviceImeiNumber":currentDataPickerVehicleImei,"year":year,"month":month,"date":date,"start":start,"end":end}

        }
            ).done(function(jsonObject){
                //alert(jsonObject);
                //return 0;
                var startingPointLatLng = new L.LatLng(jsonObject[0]["latitude"],jsonObject[0]["longitude"]);
                var polyLineDistanceInMeters = 0;
                var polyLine = L.polyline([],{weight: 10,color:get_random_color()});//.addLatLng([7.060015,79.96121]).addTo(map);
                var currentLatLng = startingPointLatLng;
                var bearings = new Array();
                var stopedCount = new Array();
                var distanceDiff = 0;
                var currentTime = null;
                
                var stoppedAt = null;
                var continueAt = null;
                
                for ( var sections in jsonObject) {
                		for ( var pass in sections) {
                    	currentLongitude = jsonObject[sections]["longitude"];
                        currentLatitude = jsonObject[sections]["latitude"];
                        var nextLatLng = new L.LatLng(currentLatitude,currentLongitude); 
                        distanceDiff = currentLatLng.distanceTo(nextLatLng);
                        currentLatLng = nextLatLng;
                        
                        polyLineDistanceInMeters += distanceDiff;
                        //alert(polyLineDistanceInMeters);         
                        bearings.push(parseFloat(jsonObject[sections]["bearing"]));
						// marker.setIconAngle(parseFloat(jsonData[items]["bearing"]));
                       
                        polyLine.addLatLng([currentLatitude,currentLongitude]);
                        
                        if(distanceDiff == 0){
                        	if(! stoppedAt){
								splitedTime = jsonObject[sections]["sat_time"].split(" ");
	                        	date = splitedTime[0].split("-");
	                        	time = splitedTime[1].split(":");
	                        	currentTime = new Date(date[0],date[1],date[2],time[0],time[1],time[2],0);
	                        	stoppedAt = currentTime;
                        	}
                        		
                        	//add poit to line
                        	continue;
                        	//alert(currentTime.get);
                        }
                        
                        
                        if(stoppedAt){
                        	splitedTime = jsonObject[sections]["sat_time"].split(" ");
                        	date = splitedTime[0].split("-");
                        	time = splitedTime[1].split(":");
                        	currentTime = new Date(date[0],date[1],date[2],time[0],time[1],time[2],0);
                        	continueAt = currentTime;
                        	stoppedTime = (stoppedAt - continueAt)/1000;
                        	
                        	if(stoppedTime > 60){
                        		//alert(stoppedTime);	
	                        	stoppedPointCircle = L.circle(currentLatLng,40,{color:"red",stroke:true,fillColor:"blue",weight:2});
	                    		stoppedPointCircle.addTo(map).bindPopup("Stopped for "+stoppedTime/60 + "Minutes").openPopup();
                        		
                        	}
                	    	stoppedAt = null;
                        }
                        
                        

                              
					}
					
				}	
					//alert(bearings);
					animatedMarker = L.animatedMarker(polyLine.getLatLngs(),{
						icon:prime_mover_icon_offline,
						bearingsArray: bearings
									
					});
					map.addLayer(animatedMarker);
					var polyLinePopupContent = "<a style = 'color:red'>Total Distance = "+polyLineDistanceInMeters.toFixed(1) +"(in meters)("+(polyLineDistanceInMeters/1000).toFixed(1)+"Km)</a>";
                    polyLine.bindLabel(polyLinePopupContent);
					polyLine.addTo(map);
                    //alert("done2");
                    //var polyLinePopUp
                    var startingPointCircle = L.circle(startingPointLatLng,50,{color:"green",stroke:true,fillColor:"red",weight:2});
                    startingPointCircle.addTo(map).bindPopup("Starting Point @ "+jsonObject[0]["sat_time"]+" Time").openPopup();
                	polyLine.on('click', function () { map.removeLayer(polyLine);animatedMarker.stop();map.removeLayer(animatedMarker);map.removeLayer(startingPointCircle);});
                    
                });
    //var polyLine = L.polyline([,]).addTo(map);
    $('#commonMessageBox').fadeOut('slow');
    $('#datePicker').fadeOut('slow');
}



/*---------------------------------- End ----------------------------------*/

function onClickPolyLinePopupOpenner(mouseEventObject){
     //alert(mouseEventObject.latlng);


	     
}


function getActivities(){

	$("#vehicle_history_div").hide();
//alert("ok");
$("#commonMessageBoxResultBox").html("");
$("#commonMessageBox").fadeIn("slow");

$("#commonMessageBoxResultBox").html(loadingImage).load("./features/userActivities.php");

	     
}

var imeiNum ;
var decision ;

function setDecision(imeiNumber,decisionMade){
//alert(imeiNumber+decisionMade);
	 imeiNum = imeiNumber;
	 decision = decisionMade;
	 $("#commonMessageBoxResultBox").html(loadingImage).load("./features/newVehicleRegistration.php?imei="+imeiNumber);
	 return 0;
     
	     
}


function registerNewVehicle(){
	//alert(imeiNum + decision + $("#vehicle_registration_number").val() + $("#vehicle_owner").val() );
	vehicle_registration_number = $("#vehicle_registration_number").val();
	vehicle_owner = $("#vehicle_owner").val();
	
	 $.post("./features/vehicleAuthenticationStatus.php",{"decision":decision,"imei":imeiNum,"vehicle_registration_number":vehicle_registration_number,"vehicle_owner":vehicle_owner}).done(
	  function(returnData){
	      if(decision == "approve"){
	          alert("<"+imeiNum+">"+" will allowed to connect to main server");
	
	          }
		  approveVehicles();
	      });

}

//------------------------------ Generate random colos on the fly Use get_random_color() in place of "#0000FF" ----------------------

function get_random_color() {
    
    // var letters = '0123456789ABCDEF'.split('');
    // var color = '#';
    // for (var i = 0; i < 6; i++ ) {
        // color += letters[Math.round(Math.random() * 15)];
    // }
    // return color;
    
    

// take 3 random values, presumably this will be similar to MD5 bytes
var r = Math.floor(Math.random() * 255);
var g = Math.floor(Math.random() * 50); // optimize for generating more red colors 
var b = Math.floor(Math.random() * 50); // optimize for generating more red colors 
 
// floor again
r = Math.floor(r);
g = Math.floor(g);
b = Math.floor(b);
 
if (r < 50 && g < 50 && b < 50) r += 150;
 
//if (r > 150 && g > 150 && b > 150) r -= 100;
 
if (Math.abs(r - g) < 50 && Math.abs(r - b) < 50 && Math.abs(g - b) < 50) {
//if (r > 50) r -= 50;// optimize for generating more red colors 
if (g > 50) g -= 50;
//if (b < 200) b += 50; // optimize for generating more red colors 
}
 
var rstr = r.toString(16);
var gstr = g.toString(16);
var bstr = b.toString(16);
 
// pad 0's -- probably a better way, but this was easy enough.
if (rstr.length === 1) {
rstr = "0" + rstr;
}
if (gstr.length === 1) {
gstr = "0" + gstr;
}
if (bstr.length === 1) {
bstr = "0" + bstr;
}
 //alert('#'+rstr + gstr + bstr);
return '#'+rstr + gstr + bstr;

    
    
    
    
}


</script>
</head>
<body
     style="background-image: url('../media/images/backgrounds/map_background6.jpg'); margin: 0; padding: 0;">
     




<!-- This is the off-canvas sidebar -->
<div id="my-id" class="uk-offcanvas">
    <div class="uk-offcanvas-bar">



<p style="color: red;">
	New style testing side bar buttons are not working
</p>

<ul class="uk-nav uk-nav-offcanvas uk-nav-parent-icon" data-uk-nav="">
                                        <li><a href="">Item</a></li>
                                        <li class="uk-active"><a href="">Active</a></li>

                                        <li class="uk-parent">
                                            <a href="#">Parent</a>
                                            <div style="overflow:hidden;height:0;position:relative;"><ul class="uk-nav-sub">
                                                <li><a href="">Sub item</a></li>
                                                <li><a href="">Sub item</a>
                                                    <ul>
                                                        <li><a href="">Sub item</a></li>
                                                        <li><a href="">Sub item</a></li>
                                                    </ul>
                                                </li>
                                            </ul></div>
                                        </li>

                                        <li class="uk-parent">
                                            <a href="#">Parent</a>
                                            <div style="overflow:hidden;height:0;position:relative;"><ul class="uk-nav-sub">
                                                <li><a href="">Sub item</a></li>
                                                <li><a href="">Sub item</a></li>
                                            </ul></div>
                                        </li>

                                        <li><a href="">Item</a></li>

                                        <li class="uk-nav-header">Header</li>
                                        <li class="uk-parent"><a href=""><i class="uk-icon-star"></i> Parent</a></li>
                                        <li><a href=""><i class="uk-icon-twitter"></i> Item</a></li>
                                        <li class="uk-nav-divider"></li>
                                        <li><a href=""><i class="uk-icon-rss"></i> Item</a></li>
                                    </ul>











        
    </div>
</div>







     <!-- for full page background style="background-image: url('../media/images/backgrounds/map_background3.jpg'); background-size: cover; -moz-background-size: cover; -webkit-background-size: cover; margin: 0; padding: 0;" -->
     <!-- Open street maps via leaflet javascript framework-->

			<div id="commonMessageBox"
			style="position: absolute; z-index: 4; width: 85%; height: 85%; margin-left: auto;
			 margin-right: auto; background: rgba(22, 14, 20, 0.9); border-radius: 12px; 
			 box-shadow: 0px 0px 20px 5px #000000; display: none;top: 20px;left: 20px;cursor: move;">

				<img onclick="$('#commonMessageBox').fadeOut('slow')"
				alt="Close" src="../media/images/logins/close.png"
				width="24" height="24"
				alt="Close"
				style="position: relative; float: right; top: -10px;cursor: pointer;right: -10px" />
				<br />
				<br />
				<div id="vehicle_history_div" style="display: none;z-index: 999999">

					<div id="datePicker"
					style="position: relative;float: left;left: 50px;">

					</div>
					<div id="time_picker_1" style="float: right;">

					</div>
					<div id="time_picker_2" style="float: right;top: 0px;">

					</div>
					<br />
					<div id="histroy_dates" style="float: right;height: 300px;background-color: green;overflow: scroll;overflow-style: auto;width: 200px;">

					</div>

				</div>

				<br />
				<div id="commonMessageBoxResultBox"
				style="overflow: auto; height: 75%; position: relative; width: auto; margin-right: auto; margin-left: auto;">

				</div>

			</div>
<div id="map"
		style="position: absolute; width: 100%; height: 100%; float: left; margin-left: auto; margin-right: auto; 
		background: rgba(123, 98, 159, 0.9); border-radius: 15px; box-shadow: 0px 0px 20px 5px #000000;">
			OSM Layer



		</div>

		<img style="position: fixed; float: right; margin: 0; padding: 0;"
		id="serverStatusImage" alt="serverStatus"
		src="../media/images/icons/serverStatus/status_yellow.png">

		<div id="functionButtons"
		style="position: relative; width: 85%; margin-left: auto; margin-right: auto; background-color: maroon; background: rgba(20, 15, 1, 0.9); border-radius: 8px; box-shadow: 0px 0px 20px 1px #001221;">

<!-- This is the button toggling the off-canvas sidebar -->

<i style="cursor: pointer;color: white;" class="fa fa-th fa-3x" data-uk-offcanvas="{target:'#my-id'}"></i>

			<?php if($_SESSION["admin"] == TRUE) {
			?>
			<button style="color: red;" id="approve_vehicles_to_map"
			onclick="approveVehicles()" class="styled-button-10">
				Add
				Vehicles to map
			</button>

			<button id="getActivities" class="styled-button-8"
			onclick="getActivities()" style="color: red;">
				Show Web
				activities
			</button>

			<?php }
			?>




			<button id="showVehicleHistory" class="styled-button-8"
			onclick="showVehicleHistory()">
				Show Vehicle History
			</button>
			<button id="get_administrators" class="styled-button-8"
			onclick="changeMap()">
				Change map type
			</button>
			
			<button id="get_administrators" class="styled-button-8"
			onclick="window.location.href = 'features/displayEngineFuelState.php'">
				See Fuel Level
			</button>
			
			<a id="currentVehicleStatus" style="color: red;font-size: small;">Total Primovers <span id = "totalRegisterdPrimovers" style="color: activecaption;font-size: x-large;"></span> Online Primovers <span id = "currentOnlinePrimovers" style="color: aqua;font-size: x-large;"></span> </a>

			<button id="loguot_button" class="styled-button-8"
			style="float: right;"
			onclick="window.location.href = './logout.php' ">
				Logout
			</button>

			<div id="ajax_result_div" style="position: relative;"></div>

		</div>
		<div id="leftSideSlidePane"
		style="position: fixed; float: left; height: 91%; width: 10%; background-color: red; z-index: 2; background: rgba(22, 14, 20, 0.9); border-radius: 12px; box-shadow: 0px 0px 20px 5px #000000; display: none;">
			<img
			onclick="$('#leftSideSlidePane').hide('slide',{direction:'left'})"
			alt="Close" src="../media/images/logins/no.ico"
			style="position: relative; float: right; top: 0px;" />
			<br />
			<br />
			<br />
			<div id="leftSideSlidePaneResultBox"
			style="overflow: auto; height: 100%;"></div>

		</div>


     <script type="text/javascript">
		

	
	
	</script>
     <!-- Open street maps via leaflet javascript framework  end -->



     <img id="serverStatusImage" style="display: none;"
          alt="serverStatus"
          src="../media/images/icons/serverStatus/status_yellow.png" />
     <img id="serverStatusImage" style="display: none;"
          alt="serverStatus"
          src="../media/images/icons/serverStatus/status_red.png" />
     <img id="serverStatusImage" style="display: none;"
          alt="serverStatus"
          src="../media/images/icons/serverStatus/status_green.png" />
</body>

</html>











<script>
	
	/*
	 
	 * 
	 * 
	 * /*---------------------changeIconSize method - to change the marker size when the map zoom level has changed ----------------
	function changeIconSize(){
	
	
		iconSize: [24,24],
		//shadowSize: [0,0],
		iconAnchor: [+12,+12],
		popupAnchor: [-2,-5] //[-3,-76]
		});
		
		var currentZoom = map.getZoom();
		var maxZoom = map.getMaxZoom();
		var defaultIconSize = new L.Point(24, 24);
		var transformation = new L.Transformation(1, 0, 1, 0);
		var newIconSize = transformation.transform(defaultIconSize, sizeFactor(currentZoom));
		var ancorSize = Math.round(12*currentZoom/maxZoom)
		var newIconAnchor = new L.Point(ancorSize, ancorSize);
		
		
		for (var vehicle in currentVehicleList){
			
			
			prime_mover_icon_online = L.icon({
					iconUrl : "../media/images/map/prime_mover_icon_online.png",
					//shadowUrl: '',
			
					iconSize: [24,24],
					//shadowSize: [0,0],
					iconAnchor: [+12,+12],
					popupAnchor: [-2,-5] //[-3,-76]
					});

			new_icon = prime_mover_icon_online;
			
			if (vehicle in offlinePrimovers){
			prime_mover_icon_offline = L.icon({
				iconUrl : "../media/images/map/prime_mover_icon_offline.png",
				iconSize: newIconSize,
				iconAnchor: newIconAnchor,
				popupAnchor: [-2,-5] //[-3,-76]
					});
			new_icon = prime_mover_icon_offline;
			alert(vehicle);
			
			}
			

			currentVehicleList[vehicle].marker.setIcon(new_icon);
		}
		return 0;
}



function sizeFactor(zoom) {
	  if (zoom <= 8) return 0.3;
	  else if (zoom == 9) return 0.4;
	  else if (zoom == 10) return 0.5;
	  else if (zoom == 11) return 0.7;
	  else if (zoom == 12) return 0.85;
	  else if (zoom == 13) return 1.0;
	  else if (zoom == 14) return 1.3;
	  else if (zoom == 15) return 1.6;
	  else if (zoom == 16) return 1.9;
	  else // zoom >= 17
	  return 2.2;
}
	 * 
	 * 
	 * */
	
</script>















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

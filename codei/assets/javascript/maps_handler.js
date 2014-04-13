/* ------------------------------------ current browser (client) displaying imei numbers ------------------------------------ */

var currentVehicleList = []; //current browser (client) displaying imei numbers
var totalVehicleList = []; //current browser (client) displaying imei numbers
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
		iconUrl : "assets/images/images/map/prime_mover_icon_offline.png",
		//shadowUrl: '',

		iconSize: [24,24],
		//shadowSize: [0,0],
		iconAnchor: [+12,+12],
		popupAnchor: [-2,-5] //[-3,-76]
		});

	prime_mover_icon_online = L.icon({
		iconUrl : "assets/images/images/map/prime_mover_icon_online.png",
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


/* ------------------------------------ fetch data from maps/get_coordinates using ajax------------------------------------ */

var jsonData;
$(document).ready(
	
	
 

	
          
					function (){
						 $('input[name="daterange"]').daterangepicker();
						 init_typeahead();
        
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
							url:"maps/get_coordinates",
							dataType : "json",
							type : "POST",
							data : {"firstTime":"yes"}
							}
								).done(
										function (jsonObject){
											//alert(jsonObject);
											jsonData = jsonObject;//assign to jsonData global variable to wider accecebility
											for(items in jsonData){
												var imeiNumberAsKey = String(jsonData[items]["vehicle_id"]);
												// alert(jsonData[items]["disconnected_on"]);
												if((jsonData[items]["disconnected_on"] == null)){
													// alert(jsonData[items]["disconnected_on"]);
													totalVehicleList[imeiNumberAsKey] = new primeMover(jsonData[items]["vehicle_id"], jsonData[items]["latitude"], jsonData[items]["longitude"], jsonData[items]["sat_time"],"noDataAvailable","NoMarker",jsonData[items]["speed"]);
													continue;
												}
												// alert(imeiNumberAsKey);
												totalVehicleList[imeiNumberAsKey] = new primeMover(jsonData[items]["vehicle_id"], jsonData[items]["latitude"], jsonData[items]["longitude"], jsonData[items]["sat_time"],"noDataAvailable","NoMarker",jsonData[items]["speed"]);
												
												currentVehicleList[imeiNumberAsKey] = new primeMover(jsonData[items]["vehicle_id"], jsonData[items]["latitude"], jsonData[items]["longitude"], jsonData[items]["sat_time"],"noDataAvailable","NoMarker",jsonData[items]["speed"]);
												
												//alert(currentVehicleList[imeiNumberAsKey].imeiNumber);
												//interMidVar = parseFloat(jsonData[items]["latitude"]);
												
												message = '<?php if($_SESSION["admin"] == TRUE) echo "Administrator Features";else echo "Normal User Features";  ?>';//Display administrator elements 
												
												currentVehicleList[imeiNumberAsKey].marker = L.marker([parseFloat(jsonData[items]["latitude"]),parseFloat(jsonData[items]["longitude"])],{icon:prime_mover_icon_offline,iconAngle: parseInt(jsonData[items]["bearing"])}).addTo(map);
												
												
												//popupCSSdisplay = "<b>GPS/GPRS Device imei Number: <font style='color:red;'>"+jsonData[items]["vehicle_id"]+"</font></b><br/>Current GPS Coordinates<ul><li>Latitude: "+ jsonData[items]["latitude"]+"</li><li>Longitude: "+jsonData[items]["longitude"]+"</li></ul>"+"<font style='color:blue'>"+message+"</font>";
												popupCSSdisplay = "<b>GPS/GPRS Device imei Number: <font style='color:red;'>"
                                                                      +jsonData[items]["vehicle_id"]+"</font></b><br/>Current GPS Coordinates<ul><li>Latitude: "+ jsonData[items]["latitude"]+"</li><li>Longitude: "+jsonData[items]["longitude"]+"</li></ul><br/>"
                                                                      +"<font style='color:blue'>"+message+"</font>"
                                                                      +"<br/> Current speed is <span style='color:green'> "+currentVehicleList[jsonData[items]["vehicle_id"]].currentSpeed+"</span>Kmph";

                                                            
                                                            currentVehicleList[imeiNumberAsKey].marker.bindPopup(popupCSSdisplay);//.openPopup() for open popup at the begining
												
													
														}
										//	map.setView([parseFloat(jsonData[items]["latitude"]),parseFloat(jsonData[items]["longitude"])], 15);

                                            
	                                        setInterval(ajaxCheck, 1000);

		$.ajax({
			url : "vehicles/counts",
			type : "GET",
		}).done(function(count) {
			$("#totalRegisterdPrimovers").html(count);

		});

											}
										
										
										);
						
						}
					/*---------------------------------- End ----------------------------------*/
		
		);
/*---------------------------------- End ----------------------------------*/
 
/*---------------------------------- ajaxCheck method----------------------------------*/

function ajaxCheck(){   
	
     					$("#serverStatusImage").attr("src","assets/images/images/icons/serverStatus/status_red.png");
						/* ----------------------- AJAX orginal method for getting Json data ---------------------- */
						
						$.ajax({
							url:"maps/get_coordinates",
							dataType : "json",
							type : "GET",
							data : ""
							}
								).done(
										function (jsonObject){
                                            // alert(jsonObject);
                                            currentOnlinePrimovers = jsonObject.length;
                                            $("#serverStatusImage").attr("src","assets/images/images/icons/serverStatus/status_green.png");
     										jsonData = jsonObject;
                                            offlinePrimovers = currentVehicleList;
                                            latestRecivedVehicleIds = [];
											for(items in jsonData){
												latestRecivedVehicleIds.push(jsonData[items]["vehicle_id"]);  
												/* debug code to check recevied values from ajax 
												alert(" Serial "+ jsonData[items]["serial"]+" IMEI "+ jsonData[items]["vehicle_id"]+" Latitude "+ jsonData[items]["latitude"]+" longitude "+ jsonData[items]["longitude"]+" Sat_time "+ jsonData[items]["sat_time"]);
												*/

												/* ------------------------------------- Prevent addnig already exsisted vehicle to the map (no overlapping tow vehicles)-------------------------------------*/
												// alert(jsonData[items]["vehicle_id"]);
												if(jsonData[items]["vehicle_id"] in currentVehicleList){
													//alert("Already In The Vehicle List"+jsonData[items]["vehicle_id"]);
	                                                currentVehicleList[jsonData[items]["vehicle_id"]].marker.setLatLng([parseFloat(jsonData[items]["latitude"]),parseFloat(jsonData[items]["longitude"])]);
	                                                currentVehicleList[jsonData[items]["vehicle_id"]].marker.setIconAngle(parseInt(jsonData[items]["bearing"]));
													currentVehicleList[jsonData[items]["vehicle_id"]].currentSpeed =  jsonData[items]["speed"];     
													currentVehicleList[jsonData[items]["vehicle_id"]].marker.setIcon(prime_mover_icon_online);                    
													//alert("New Lat Long has been set");
													message = '<?php if($_SESSION["admin"] == TRUE) echo "Administrator Features";else echo "Normal User Features";  ?>';
													popupCSSdisplay = "<b>GPS/GPRS Device imei Number: <font style='color:red;'>"
                                                                      +jsonData[items]["vehicle_id"]+"</font></b><br/>Current GPS Coordinates<ul><li>Latitude: "+ jsonData[items]["latitude"]+"</li><li>Longitude: "+jsonData[items]["longitude"]+"</li></ul><br/>"
                                                                      +"<font style='color:blue'>"+message+"</font>"
                                                                      +"<br/> Current speed is <span style='color:green'> "+currentVehicleList[jsonData[items]["vehicle_id"]].currentSpeed+"</span>Kmph";


                    													currentVehicleList[jsonData[items]["vehicle_id"]].marker._popup.setContent(popupCSSdisplay);
													continue;
													}
												/* Add new vehicle to map if it is not in the currentVehicleList list*/
												var imeiNumberAsKey = String(jsonData[items]["vehicle_id"]);
												currentVehicleList[imeiNumberAsKey] = new primeMover(jsonData[items]["vehicle_id"], jsonData[items]["latitude"], jsonData[items]["longitude"], jsonData[items]["sat_time"],"noDataAvailable","NoMarker",jsonData[items]["speed"]);
												//alert(currentVehicleList[imeiNumberAsKey].imeiNumber);
												//interMidVar = parseFloat(jsonData[items]["latitude"]);
												

												currentVehicleList[imeiNumberAsKey].marker = L.marker([parseFloat(jsonData[items]["latitude"]),parseFloat(jsonData[items]["longitude"])],{icon:prime_mover_icon_online,iconAngle: parseInt(jsonData[items]["bearing"])}).addTo(map);
												currentVehicleList[imeiNumberAsKey].marker.bindPopup("<b>GPS/GPRS Device imei Number</b><br>Vehicle Registration Number");//.openPopup() for open popup at the begining
												//alert("Vehicle Add Compleated");
												
														}
														for(imeiNumberIndex in currentVehicleList){
															if($.inArray(currentVehicleList[imeiNumberIndex].imeiNumber,latestRecivedVehicleIds) == -1){
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

function approveVehicles() {
	$("#vehicle_history_div").hide();
	///need to replace with commen clear function

	$.ajax({
		url : "./features/vehicleAuthenticationStatus.php",

	}).done(function(returnHttpObject) {
		//alert(returnHttpObject);
		$("#commonMessageBoxResultBox").html("");
		document.getElementById("commonMessageBoxResultBox").innerHTML = returnHttpObject;
		$("#commonMessageBox").fadeIn("slow");

	});

}




function showVehicleHistory() {

	$("#vehicle_history_div").hide();

	//alert("Not implimented"); //for check function call working
	$("#leftSideSlidePane").show("slide", {
		direction : "left"
	});

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

var loadingImage = '<img alt="Loading......" src="assets/images/images/icons/loading.gif">';

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
                        
                        if(distanceDiff < 5){
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
	
	 $.post("./features/vehicleAuthenticationStatus.php",{"decision":decision,"vehicle_id":imeiNum,"vehicle_registration_number":vehicle_registration_number,"vehicle_owner":vehicle_owner}).done(
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


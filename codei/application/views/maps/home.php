<link href=<?= base_url() . 'assets/styles/maps_home.css' ?> rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="assets/styles/jquery-ui.css" />
<link rel="stylesheet" href="assets/styles/leaflet.css" />
<link rel="stylesheet" href="assets/styles/leaflet.label.css" />
<link rel="stylesheet" href="assets/styles/jquery-ui-timepicker-addon.css" />
<link rel="stylesheet" href="assets/styles/uikit.min.css" />
<link
href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css"
rel="stylesheet">

<script src="assets/javascript/uikit.min.js"></script>
<script src="assets/javascript/leaflet.js"></script>
<script src="assets/javascript/leaflet.label.js"></script>
<script src="assets/javascript/AnimatedMarker.js"></script>
<script src="assets/javascript/Marker.Rotate.js"></script>
<script src="assets/javascript/maps_handler.js"></script>
<body
style="margin: 0; padding: 0;">

	<!-- This is the off-canvas sidebar -->
	<div id="left_side_pannel" class="uk-offcanvas">
		<div class="uk-offcanvas-bar">

			<p style="color: yellow">
				New style testing side bar SOME buttons
				are not implimented yet.
			</p>

			<ul class="uk-nav uk-nav-offcanvas uk-nav-parent-icon" data-uk-nav="">
				<li>
					<a id="approve_vehicles_to_map" onclick="approveVehicles()"><i
					class="fa fa-plus"></i> Add Vehicles to Map</a>
				</li>
				<!-- if want to make a button active set class="uk-active" on onClick event  -->
				<li>
					<a id="getActivities" onclick="getActivities()"><i
					class="fa fa-bell"></i> Show Web Activities</a>
				</li>

				<li class="uk-parent">
					<a id="showVehicleHistory"
					onclick="showVehicleHistory()"><i class="fa fa-calendar"></i> Show
					Vehicle History</a>
					<div style="overflow: hidden; height: 0; position: relative;">
						<ul class="uk-nav-sub">
							<li>
								<a href="">Sub item</a>
							</li>
							<li>
								<a href="">Sub item</a>
								<ul>
									<li>
										<a href="">Sub item</a>
									</li>
									<li>
										<a href="">Sub item</a>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</li>

				<li class="uk-parent">
					<a id="get_administrators"
					onclick="changeMap()"><i class="fa fa-exchange"></i> Change Map
					Type</a>
					<div style="overflow: hidden; height: 0; position: relative;">
						<ul class="uk-nav-sub">
							<li>
								<a href="">Sub item</a>
							</li>
							<li>
								<a href="">Sub item</a>
							</li>
						</ul>
					</div>
				</li>

				<li>
					<!-- fa fa-tachometer -->
					<a id="get_administrators"
					onclick="window.location.href = 'features/displayEngineFuelState.php'"><i
					class="fa fa-signal"></i> Fuel Level</a>
				</li>

				<?php
				$session_data = $this -> session -> userdata('logged_in');

				if($session_data['isAdmin']) {
				?>
				<li class="uk-nav-header">
					System Administrtion
				</li>
				<li class="uk-parent">
					<a href=""><i class="fa fa-bar-chart-o"></i> View System Status</a>
				</li>
				<li>
					<a href=""><i class="fa fa-users"></i> Manage Users</a>
				</li>
				<li class="uk-nav-divider"></li>
				<?php } ?>

				<li>
					<a id="loguot_button" href="login/logout"><i
					class="fa fa-sign-out"></i> Logout</a>
				</li>
			</ul>

		</div>
	</div>

	<!-- for full page background style="background-image: url('assets/images/images/backgrounds/map_background3.jpg'); background-size: cover; -moz-background-size: cover; -webkit-background-size: cover; margin: 0; padding: 0;" -->
	<!-- Open street maps via leaflet javascript framework-->

	<div id="commonMessageBox"
	style="position: absolute; z-index: 4; width: 85%; height: 85%; margin-left: auto; margin-right: auto; background: rgba(22, 14, 20, 0.9); border-radius: 12px; box-shadow: 0px 0px 20px 5px #000000; display: none; top: 20px; left: 20px; cursor: move;">

		

		<img onclick="$('#commonMessageBox').fadeOut('slow')" alt="Close"
		src="assets/images/images/logins/close.png" width="24" height="24"
		alt="Close"
		style="position: relative; float: right; top: -10px; cursor: pointer; right: -10px" />
		<br />
		<br />
		
		

		<div id="vehicle_history_div" style="display: none; z-index: 999999">

			<div id="datePicker"
			style="position: relative; float: left; left: 50px;"></div>
			<div id="time_picker_1" style="float: right;"></div>
			<div id="time_picker_2" style="float: right; top: 0px;"></div>
			<br />
			<div id="histroy_dates"
			style="float: right; height: 300px; background-color: green; overflow: scroll; overflow-style: auto; width: 200px;">

			</div>

		</div>

		<br />
		<div id="commonMessageBoxResultBox"
		style="overflow: auto; height: 75%; position: relative; width: auto; margin-right: auto; margin-left: auto;">

		</div>

	</div>
	<div id="map"
	style="position: absolute; width: 100%; height: 100%; float: left; margin-left: auto; margin-right: auto; background: rgba(123, 98, 159, 0.9); border-radius: 15px; box-shadow: 0px 0px 20px 5px #000000;">
		OSM Layer
	</div>

	<i
	style="position: fixed; float: left; left: 50px; cursor: pointer; color: #4862a2;"
	class="fa fa-globe fa-3x"
	data-uk-offcanvas="{target:'#left_side_pannel'}"></i>

	<div id="functionButtons" class="text-center"
	style="position: relative; width: 35%; margin-left: auto; margin-right: auto; background-color: maroon; background: rgba(20, 15, 1, 0.9); border-radius: 8px; box-shadow: 0px 0px 20px 1px #001221;">

		<img style="position: fixed; float: right; right: 0px"
		id="serverStatusImage" alt="serverStatus"
		src="assets/images/images/icons/serverStatus/status_yellow.png">

		<!-- This is the button toggling the off-canvas sidebar -->

		<!-- http://www.arungudelli.com/jquery/simple-jquery-autocomplete-search-tutorial/ , http://www.w3resource.com/twitter-bootstrap/typehead.php, http://www.a2zwebhelp.com/bootstrap-autocomplete-->

		<form style="border-radius: 8px;background: rgba(200, 250, 210, 0.9);" class="uk-search" data-uk-search="{source:'./features/getVehicleList.php'}">
			<input autofocus="True" class="uk-search-field" type="search" placeholder="Search">

			<button class="uk-search-close" type="reset"></button>
		</form>

		<span id="currentVehicleStatus" style="color: red; font-size: small;">Total
			Primovers <span id="totalRegisterdPrimovers"
			style="color: activecaption; font-size: x-large;"></span> Online
			Primovers <span id="currentOnlinePrimovers"
			style="color: aqua; font-size: x-large;"></span> </span>

		<div id="ajax_result_div" style="position: relative;">

		</div>

	</div>
	<div id="functionButtons" class="text-center"
	style="position: relative; width: 45%; margin-left: auto; margin-right: auto; background-color: maroon; background: rgba(20, 15, 1, 0.9); border-radius: 8px; box-shadow: 0px 0px 20px 1px #001221;">

		<i style= "color:red;" class="fa fa-exclamation-triangle fa-2x"></i>
		<span style = "color: yellow;"> Moving to new framework </span>
	</div>

	<div id="leftSideSlidePane"
	style="position: fixed; float: left; height: 91%; width: 10%; background-color: red; z-index: 2; background: rgba(22, 14, 20, 0.9); border-radius: 12px; box-shadow: 0px 0px 20px 5px #000000; display: none;">
		<img
		onclick="$('#leftSideSlidePane').hide('slide',{direction:'left'})"
		alt="Close" src="assets/images/images/logins/no.ico"
		style="position: relative; float: right; top: 0px;" />
		<br />
		<br />
		<br />
		<div id="leftSideSlidePaneResultBox"
		style="overflow: auto; height: 100%;"></div>

	</div>

	<!-- Open street maps via leaflet javascript framework  end -->

	<img id="serverStatusImage" style="display: none;" alt="serverStatus"
	src="assets/images/images/icons/serverStatus/status_yellow.png" />
	<img id="serverStatusImage" style="display: none;" alt="serverStatus"
	src="assets/images/images/icons/serverStatus/status_red.png" />
	<img id="serverStatusImage" style="display: none;" alt="serverStatus"
	src="assets/images/images/icons/serverStatus/status_green.png" />
</body>


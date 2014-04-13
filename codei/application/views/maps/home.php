<link href=<?= base_url() . 'assets/styles/maps_home.css' ?> rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="assets/styles/jquery-ui.css" />
<link rel="stylesheet" href="assets/styles/leaflet.css" />
<link rel="stylesheet" href="assets/styles/leaflet.label.css" />
<link rel="stylesheet" href="assets/styles/uikit.min.css" />
<link rel="stylesheet" href="assets/styles/daterangepicker-bs3.css" />


<link
href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css"
rel="stylesheet">

<script src="assets/javascript/typeahead.bundle.min.js"></script>
<script src="assets/javascript/vehicle_search.js"></script>
<script src="assets/javascript/uikit.min.js"></script>
<script src="assets/javascript/leaflet.js"></script>
<script src="assets/javascript/leaflet.label.js"></script>
<script src="assets/javascript/AnimatedMarker.js"></script>
<script src="assets/javascript/Marker.Rotate.js"></script>
<script src="assets/javascript/maps_handler.js"></script>
<script src="assets/javascript/moment.min.js"></script>
<script src="assets/javascript/daterangepicker.js"></script>


<body style="margin: 0; padding: 0;">
	<div id="map">

	</div>
<nav class="navbar navbar-default" role="navigation" style="width: 75%;margin-left: auto;margin-right: auto;">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
 		<i style="cursor: pointer;" data-uk-offcanvas="{target:'#left_side_pannel'}" class="fa fa-arrow-circle-right fa-2x navbar-brand"></i>
	
    </div>



    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse " id="bs-example-navbar-collapse-1">
      
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group the-basics">
          <input autofocus="enable" type="text" class="typeahead form-control" placeholder="Vehicle Registration #">
        </div>
      </form>
      
      
      <ul class="nav navbar-nav">
<p class="navbar-text" >
      		Total
			Primovers <span id="totalRegisterdPrimovers"
			style="color: rgb(185, 39, 39); font-size: x-large;"></span>
      	</p>
      	<p class="navbar-text" >
      		Online
			Primovers <span id="currentOnlinePrimovers"
			style="color: rgb(10, 129, 134); font-size: x-large;"></span>
      	</p>
       
			
			</ul>
      
      <ul class="nav navbar-nav navbar-right">
      	
        <p class="navbar-text ">Signed in as <span class="text-primary">
<?php
			$session_data = $this -> session -> userdata('logged_in');
			echo $session_data['full_name'];
          	?>
</span>
</p>
	<p class="navbar-text navbar-right">
		
	
	<img 
		id="serverStatusImage" alt="serverStatus"
		src="assets/images/images/icons/serverStatus/status_yellow.png"/>
</p>
      </ul>
      
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


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
				<li>
					<a data-toggle="modal" data-target="#myModal"><i
					class="fa fa-bell"></i> Testing modal</a>
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



	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						&times;
					</button>
					<h4 class="modal-title" id="myModalLabel">Modal title</h4>
				</div>
				<div class="modal-body">

<div id="reportrange" class="pull-right">
    <i class="fa fa-calendar fa-lg"></i>
    <span><?php echo date("F j, Y", strtotime('-30 day')); ?> - <?php echo date("F j, Y"); ?></span> <b class="caret"></b>
</div>
 
<script type="text/javascript">
	$('#reportrange').daterangepicker({
		ranges : {
			'Today' : [moment(), moment()],
			'Yesterday' : [moment().subtract('days', 1), moment().subtract('days', 1)],
			'Last 7 Days' : [moment().subtract('days', 6), moment()],
			'Last 30 Days' : [moment().subtract('days', 29), moment()],
			'This Month' : [moment().startOf('month'), moment().endOf('month')],
			'Last Month' : [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
		},
		startDate : moment().subtract('days', 29),
		endDate : moment()
	}, function(start, end) {
		$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
	});
					</script>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">
						Close
					</button>
					<button type="button" class="btn btn-primary">
						Save changes
					</button>
				</div>
			</div>
		</div>
	</div>

</body>


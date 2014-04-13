var vehicle;
var vehicles = new Bloodhound({
	datumTokenizer : function(d) {
		return Bloodhound.tokenizers.whitespace(d.value);
	},
	queryTokenizer : Bloodhound.tokenizers.whitespace,
	remote : {
		url : 'vehicles/details?reg_number=%QUERY',
		filter : function(vehicles) {
			vehicle = vehicles;
			return ($.map(vehicles, function(vehicles) {
					return {
						value : vehicles.vehicle_registration_number
					};
				}));

		}
	}
});

function init_typeahead() {
	vehicles.initialize();
	$('.typeahead').typeahead({
		hint : true,
		highlight : true,
		minLength : 1
	}, {
		name : 'vehicles',
		displayKey : 'value',
		source : vehicles.ttAdapter()
	}).on('typeahead:autocompleted', function($e, datum) {
		selected_value = datum["value"];
		for (var v in vehicle) {
			aler(vehicle[v]);
		}
		alert(datum["value"]);
	}).on('typeahead:selected', function($e, datum) {
		selected_value = datum["value"];
		// alert(datum["value"]);

		for (var v in vehicle) {
			// alert(vehicle[v]);
			if (vehicle[v].vehicle_registration_number == selected_value) {
				// for(var g in currentVehicleList){
				// alert(currentVehicleList[g].vehicle_id);
				// }
				// alert(parseInt(vehicle[v].vehicle_id));
				map.setView(currentVehicleList[vehicle[v].vehicle_id].marker.getLatLng(),16);
				
			}
		}

	});
}


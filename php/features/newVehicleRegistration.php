<html>
	<head>
		<title>Vehicle registration form</title>
		<style>
			.lables {
				color: red;
			}
			td{
				width: 50%;
			}
		</style>
	</head>
	<body>
		<?php ?>
		<table>
			<form>
				<tr>
					<td><label class="lables">IMEI Number</label></td>
					<td>
					<input id="imei" type="text" disabled="true" value="<?php print $_GET['imei']; ?>" />
					</td>
				</tr>
				<br />
				<tr>
					<td><label class="lables">Vehicle registration number</label></td>
					<td>
					<input id="vehicle_registration_number" type="text" placeholder="GA-1234" />
					</td>
				</tr>

				<br />

				<tr>
					<td><label class="lables">Vehicle owner</label></td>
					<td>
					<input id="vehicle_owner" type="text" placeholder="SLPA"/>
					</td>
				</tr>
			<tr>
				<td>
					<input type="button" value="Approve vehicle" onclick="registerNewVehicle()" />
				</td>
			</tr>
			</form>

		</table>
	</body>
<html>
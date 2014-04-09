<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Coordinate extends CI_Model {

	public function get_live_status() {
		$this -> db -> select('vehicle_id,longitude,latitude,speed,bearing');
		$this -> db -> from('live_status');
		$this -> db -> where('disconnected_on IS NOT NULL', NULL, false);
		$query = $this -> db -> get();
		return $query;
	}

}
?>
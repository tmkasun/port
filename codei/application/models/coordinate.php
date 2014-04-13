<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Coordinate extends CI_Model {

	public function get_live_status() {
		$this -> db -> select('vehicle_id,longitude,latitude,speed,bearing');
		$this -> db -> from('live_status');
		$this -> db -> where('disconnected_on IS NULL', NULL, false);//is null means it is connected
		$query = $this -> db -> get();
		return $query;
	}

	public function all_last_known_positions()
	{
		return $this -> db -> get('live_status');
	}
}
?>
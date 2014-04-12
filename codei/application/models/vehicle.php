<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Vehicle extends CI_Model {

	public function all() {
		$query = $this -> db -> get('vehicle_details');
		return $query;
	}

	public function find($vehicle_id) {
		$this -> db -> where('vehicle_id', $vehicle_id);
		$query = $this -> db -> get('vehicle_details');
		return $query;
	}

	public function remove($vehicle_id) {
		$this -> db -> where('vehicle_id', $vehicle_id);
		$query = $this -> db -> delete('vehicle_details');
		return $query;
	}

	public function update($data) {
		//not implimented
		$data = array('title' => $title, 'name' => $name, 'date' => $date);

		$this -> db -> where('id', $id);
		$this -> db -> update('mytable', $data);
	}

	public function counts() {
		return $this -> db -> count_all('vehicle_details');
	}

}
?>

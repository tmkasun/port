<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
session_start();
class Vehicles extends CI_Controller {

	function __construct() {
		parent::__construct();
		if (!is_user_logged_in())
			redirect('login/index', 'refresh');
		$this -> load -> model('vehicle');		
	}

	public function index() {
		$query = $this -> vehicle -> all();
		$this -> output -> set_content_type('application/json') -> set_output(json_encode($query -> result()));
	}

	public function counts() {
		$query = $this -> vehicle -> counts();
		$this -> output -> set_content_type('application/json') -> set_output(json_encode($query));
	}
	
	public function details() {
		$vehicle_id = $this -> input -> post('vehicle_id');
		
		$query = $this -> vehicle -> find($vehicle_id);
		$this -> output -> set_content_type('application/json') -> set_output(json_encode($query -> result()));
	}
	

}

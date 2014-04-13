<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
session_start();
class Maps extends CI_Controller {

	public function index() {
		if (is_user_logged_in()) {
			$session_data = is_user_logged_in();
			$content_data = array('computer_number' => $session_data['computer_number'], 'full_name' => $session_data['full_name']);
			$layout_data = array('title' => "Welcome to maps", 'content' => "maps/home", 'content_data' => $content_data);
			$this -> load -> view('layouts/inner_layout', $layout_data);
		} else {
			//If no session, redirect to login page
			$this -> load -> library('form_validation');
			$this -> form_validation -> set_message('check_database', 'Invalid username or password');
			redirect('login', 'refresh');
		}
	}

	public function get_coordinates() {
		if ($this -> input -> is_ajax_request()) {
			$this -> load -> model('coordinate', "code");
			if( $this -> input -> post('firstTime')){
				$query = $this -> code -> all_last_known_positions();
				$this -> output -> set_content_type('application/json') -> set_output(json_encode($query->result()));
				return 0;
			}
			$query = $this -> code -> get_live_status();
			$this -> output -> set_content_type('application/json') -> set_output(json_encode($query->result()));
		} else {
			echo "This method is not allowed";
		}
	}

}
?>
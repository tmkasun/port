<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
session_start();
class Maps extends CI_Controller {

	public function index() {
		if ($this -> session -> userdata('logged_in')) {
			$session_data = $this -> session -> userdata('logged_in');

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

	public function logout() {
		$this -> session -> unset_userdata('logged_in');
		session_destroy();
		redirect('login', 'refresh');
	}

}
?>
<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

if (!isset($_SESSION)) {
	session_start();
}

class Login extends CI_Controller {

	public function index() {
		if (is_user_logged_in()) {
			redirect('maps', 'refresh');
		} else {
			$this -> load -> helper(array('form'));
			$this -> load -> view('login/index');
		}
	}

	public function logout() {
		$this -> session -> unset_userdata('logged_in');
		session_destroy();
		redirect(base_url(), 'refresh');
	}

}
?>
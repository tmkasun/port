<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index() {
		$this -> load -> helper(array('form'));
		$this -> load -> view('login/index');
		// $this -> load -> model('user');
		// $result = $this -> user -> login("123456", "123456");
		// echo $result -> loginApprovalBit;
	}

}
?>
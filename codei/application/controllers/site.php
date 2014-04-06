<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller {
	public function index(){
			$this->home();
		}

	public function home(){
		$data["title"] = "kasun thennakoon";
		$this->load->view("home",$data);
	}
	public function about(){
		$data["title"] = "about";
		$this->load->view("about",$data);
	}
	public function adders(){
		echo "adders";
		$this->load->model("math");
		echo $this->math->adder(5,6);
	}
}

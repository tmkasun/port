<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller {
	public function index(){
			$this->load->model('user');
			$res = $this->user->login("123456","123456");
			if($res){
				print_r($res);
			}
		}

	public function home(){
		$data["title"] = "kasun thennakoon";
		$data["ret"] = $this->adders(); 
		$this->load->view("home",$data);
	}
	public function about(){
		$data["title"] = "about";
		$this->load->view("about",$data);
	}
	public function adders(){
		$this->load->model("math");
		return $this->math->adder(5,6);
	}
}

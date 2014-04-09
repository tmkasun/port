<?php
class User extends CI_Model {
	public function login($computer_number, $password) {
		$this -> db -> select('loginApprovalBit');
		$this -> db -> select('computer_number');
		$this -> db -> select('Full_Name');
		$this -> db -> from('logins');
		$this -> db -> where('computer_number', $computer_number);
		$this -> db -> where('password', MD5($password));
		$query = $this -> db -> get();
		// echeck approval bit and send notification message accordingly
		return $query -> row();

	}

	public function isAdmin($computer_number) {
		$this -> db -> select();
		$this -> db -> from('administrators');
		$this -> db -> where('computer_number', $computer_number);

		$query = $this -> db -> get();

		if ($query -> num_rows() == 1) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function update_login($computer_number)
	{
		$data = array(
		'computer_number' => $computer_number,
		'date_time' => date("Y-m-d H:i:s"),
		'ip_addr' => $this->input->ip_address(),
		'host_name' => gethostbyaddr($_SERVER['REMOTE_ADDR']),
		'browser_details' => $this->input->user_agent()
		);
		
		$this->db->insert('track',$data);
	}
	
	function get_real_ip_address() {

		if (isset($_SERVER)) {
			if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
				return $_SERVER["HTTP_X_FORWARDED_FOR"];
			if (isset($_SERVER["HTTP_CLIENT_IP"]))
				return $_SERVER["HTTP_CLIENT_IP"];
			return $_SERVER["REMOTE_ADDR"];
		}

		if (getenv(“HTTP_X_FORWARDED_FOR))
			return getenv(“HTTP_X_FORWARDED_FOR);
		if (getenv(“HTTP_CLIENT_IP))
			return getenv(“HTTP_CLIENT_IP);
		if (getenv(“REMOTE_ADDR))
			return getenv(“REMOTE_ADDR);

		return  “UNKNOWN”;

	}

}
?>
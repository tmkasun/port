<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

if (!function_exists('is_user_logged_in')) {
	function is_user_logged_in() {
		$ci=& get_instance();
		if ($ci -> session -> userdata('logged_in')) {
			$session_data = $ci -> session -> userdata('logged_in');
			return $session_data;
		} else {
			return FALSE;
		}

	}

}

?>

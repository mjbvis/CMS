<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Boiler_plate_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function get_users() {
		$query = $this->db->get('users');
		return $query;
	}

}
?>
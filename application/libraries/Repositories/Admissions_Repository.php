<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	/* This file will hold all database queries for the login model */
class Admissions_Repository {
	
	var $CI; // The CI object
	
	
	public function __construct(){
		$this->CI =& get_instance();
			
		$this->CI->load->database();
	}
	
	public function insertPageOne($data) {
		$this->CI->db->insert('admissionsPageOne', $data);
	}
	
	public function insertPageTwo($data) {
		$this->CI->db->insert('admissionsPageTwo', $data);
	}
	
	public function insertPageThree($data) {
		$this->CI->db->insert('admissionsPageThree', $data);
	}
	
	public function insertPageFour($data) {
		$this->CI->db->insert('admissionsPageFour', $data);
	}
	
	public function insertPageFive($data) {
		$this->CI->db->insert('admissionsPageFive', $data);
	}
}

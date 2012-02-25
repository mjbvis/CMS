<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	/* This file will hold all database queries for the login model */
class Registration_Repository {
	
	var $CI; // The CI object
	
	/**
	* @author Mark Bowser
	*
	* The constructor public function loads the libraries dependancies.
	*/
	public function __construct(){
		$this->CI =& get_instance();
			
		$this->CI->load->database();
	}
	
	/**
	* @author Mark Bowser
	* @param username to validate
	*
	* decides if a given username is available.
	*/
	public function selectUserAlerts($username) {
		$this->CI->db->select('username');
		$this->CI->db->from('users');
		$this->CI->db->where('username', $username);
		$results = $this->CI->db->get();
		
		return $results->num_rows() == 0;
	}

}

?>
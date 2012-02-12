<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	/* This file will hold all database queries for the login model */
class Login_Repository {
	
	var $CI; // The CI object
	
	/**
	* @author Mark Bowser
	*
	* The constructor public function loads the libraries dependancies and creates the 
	* login attempts cookie if it does not already exist.
	*/
	public function __construct(){
		$this->CI =& get_instance();
			
		$this->CI->load->database();
	}
	
	/**
	* @author Mark Bowser
	* @param user ID
	*
	* selects all alerts for the given user
	* NOTE: alerts should only work on parents
	*/
	public function selectUserAlerts($id) {
		$this->CI->db->select('UserID');
		$this->CI->db->from('UserAlerts');
		$this->CI->db->where('UserID', $id);
		$results = $this->CI->db->get();
		
		return $results;
	}

}
    
    
    

?>
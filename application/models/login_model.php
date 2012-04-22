<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
/* This file will hold all database queries for the student Table */
class Login_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();
		
		$this->load->database();
	}
	
	/**
	* @author Mark Bowser
	* @param user ID
	*
	* selects all alerts for the given user
	* NOTE: alerts should only work on parents
	*/
    public function selectUserAlerts($id) {
        $this->db->select('AlertID');
        $this->db->from('UserAlerts');
        $this->db->where('UserID', $id);
        $results = $this->db->get();
        
        return $results;
    }
    

}
?>
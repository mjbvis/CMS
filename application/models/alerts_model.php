<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
/* This file will hold all database queries for the student Table */
class Alerts_model extends CI_Model{
    
    public function __construct(){
        parent::__construct();
        
        $this->CI->load->database();
       
    }
    
    public function selectUserAlerts($id) {
        $this->CI->db->select('AlertID');
        $this->CI->db->from('UserAlerts');
        $this->CI->db->where('UserID', $id);
        $results = $this->CI->db->get();
        
        return $results;
    }
}
?>
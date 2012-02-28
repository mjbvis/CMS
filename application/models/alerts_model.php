<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
/* This file will hold all database queries for the student Table */
class Alerts_model extends CI_Model{
    
    public function __construct(){
        parent::__construct();
        $this->load->database();    
    }
    
    public function doesUserHaveAnyAlerts($id) {
        if (selectUserAlerts($id)->num_rows() > 0)
            return TRUE;
        else
            return FALSE;
    }

    public function selectUserAlerts($id) {
        $this->db->select('AlertID');
        $this->db->from('UserAlerts');
        $this->db->where('UserID', $id);
        $results = $this->db->get();
        
        return $results;
    }
}
?>
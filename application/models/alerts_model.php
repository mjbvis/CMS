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

    public function selectUserAlerts2($id) {
        $this->db->select('AlertID');
        $this->db->from('UserAlerts');
        $this->db->where('UserID', $id);
        $this->db->join('Alerts', 'Alerts.AlertID = UserAlerts.AlertID');
        $query = $this->db->get();
            
        return $query;
    }
    
    public function selectUserAlerts($id){
        return $this->db->query('select ua.AlertID, a.Description
                                 from UserAlerts as ua
                                 inner join Alerts as a
                                    on ua.AlertID = a.AlertID
                                 where UserID = ' . $id);
    }
    
    public function changeGroup($id, $group){
        $this->db->query('update users
                          set group_id = ' . $group .
                          'where id = ' . $id);
    }
    
}
?>
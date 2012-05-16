<?php

// gets any alerts for the given user.
// function selectUserAlerts($id) {
    // $this->db->select('AlertID');
    // $this->db->from('UserAlerts');
    // $this->db->where('UserID', $id);
    // $results = $this->db->get();
//     
    // return $results;
// }



function selectUserAlerts($id){
	$CI =& get_instance();
    return $CI->db->query('select ua.AlertID, a.Description
                           from UserAlerts as ua
                           inner join Alerts as a
                              on ua.AlertID = a.AlertID
                           where UserID = ' . $id);
}

function userHasAlerts($id) {
    if (selectUserAlerts($id)->num_rows() > 0)
        return TRUE;
    else
        return FALSE;
}

function changeGroup($id, $group){
	$CI =& get_instance();
    $CI->db->query('update users
                    set group_id = ' . $group .
                    ' where id = ' . $id);
					  
	// reload the group ID in the session
	$CI->session->set_userdata('group_id', $group);
}

?>
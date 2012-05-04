<?php

//probably move this function once working
function get_menu_items($group_name = NULL){
	$CI =& get_instance();
	
	// if the calling controller is not group specific,
	//	we must determine the group_name here
	if ($group_name == NULL){
		if(user_group('admin') == TRUE){
			$group_name = 'admin';
		} 
		elseif(user_group('parent') == TRUE) {
			$group_name = 'parent';
		}
		else {
			$group_name = 'alerts';
		}
	}
	
	// get the group ID from the group name
	$groupID = $CI->ag_auth->config['auth_groups'][$group_name];

	// return all menu items for that group
	return Menu_item::all(array('conditions' => array('GroupID=?', $groupID)
							    ,'joins' => array('group_menu_items')
							    ,'order' => 'RankOrder'));

	
}
	
?>
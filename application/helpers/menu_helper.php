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
			$group_name = 'parents';
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
								
	
	// EAGER LOADING MANY_TO_MANY EXPERIMENTS:
	
	//$Grp = Group::find_by_id($groupID, array('include' => array('group_menu_items' => array('menu_item'))));
	//var_dump($Grp->group_menu_items);
	//$gmi = $Grp->group_menu_items[0];
	//var_dump($gmi->menu_item);

	// $Grp = Group::find_by_id($groupID);//, array('include' => array('group_menu_items' => array('menu_item'))));
	// var_dump($Grp);
	
}
	
?>
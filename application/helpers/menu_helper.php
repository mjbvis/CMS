<?php

//probably move this function once working
function get_menu_items($group_name){
	$CI =& get_instance();
	
	$groupID = $CI->ag_auth->config['auth_groups'][$group_name];

	return Menu_item::all(array('conditions' => 'GroupID=' . $groupID
							    ,'joins' => array('group_menu_items')
							    ,'order' => 'RankOrder'));
}
	
?>
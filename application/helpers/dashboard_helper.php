<?php

//probally move this function once working
function get_dashboard()
{
		
	if(user_group('admin') == TRUE){
		return 'admin/admin';
	} 
	elseif(user_group('user') == TRUE) {
		echo "error";
		return 'parent/parent';
	}
	//elseif(user_group('alert') == TRUE) {
	//	return 'alert/alert';
	//}
	else {
		echo "error";
	}	

}
	
?>
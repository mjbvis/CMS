<?php

//probably move this function once working
function get_dashboard($alerts){
	
	// put parents in the alert group if they have alerts to deal with	
	if($alerts->num_rows()>0 && user_group('parent') == TRUE) {
		// how do you change groups???
		return 'alerts';
	}
	
	if(user_group('admin') == TRUE){
		return 'admin';
	} 
	elseif(user_group('parent') == TRUE) {
		return 'parents';
	}
	elseif(user_group('alerts') == TRUE) {
		return 'alerts';
	}
	else {
		echo "error";
	}	

}
	
?>
<?php

//probably move this function once working
function get_dashboard($alerts){
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
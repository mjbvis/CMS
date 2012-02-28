<?php

//probably move this function once working
function get_dashboard(){
    if(user_group('admin') == TRUE){
		return 'admin';
	} 
	elseif(user_group('parent') == TRUE) {
		return 'parents';
	}
	elseif(user_group('alert') == TRUE) {
		return 'alerts';
	}
	else {
		//TODO: redirect to some page that will handle this error
		return "error";
	}	

}
	
?>
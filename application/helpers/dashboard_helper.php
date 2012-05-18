<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//probably move this function once working
function get_dashboard(){
        
    $hasUserChangedPassword = checkPass();
    
    if(!$hasUserChangedPassword){
        return 'login';
    }    
        
    if(user_group('admin') == TRUE){
		return 'admin';
	} 
	elseif(user_group('parent') == TRUE) {
		return 'parents';
	}
	else {
		//TODO: redirect to some page that will handle this error
		return "error";
	}	

}
	
function checkPass(){
    $userName = username();
    $query = "select HasChangedPassword from users where username = '" . $userName . "'";
    $result = mysql_query($query);
    
    if(mysql_result($result,0,"HasChangedPassword") == 1)
        return TRUE;
    else
        return FALSE; 
}    
    
?>
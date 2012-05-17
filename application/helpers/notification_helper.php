<<<<<<< HEAD
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	// TODO: refactor this helper. This is gross. Try to use some sort of associative array.
	
	function setNotification($type , $userID, $additionalInfo = null){
		switch ($type) {
			case "waitlistAChild":
				setWaitlistAChild($userID, 1);
		}
	}
	
	function unsetNotification($type , $userID, $additionalInfo = null){
		switch ($type) {
			case "waitlistAChild":
				unsetWaitlistAChild($userID, 1);
		}		
		
	}
	
	function setWaitlistAChild($userID, $id){
	    mysql_query("INSERT INTO UserNotifications Value(" . $id . ",'" . $userID . "', '')");
	}
	
	function unsetWaitlistAChild($userID, $id){
	    mysql_query("DELETE FROM UserNotifications WHERE UserID =" . $userID . " AND NotificationID =" . $id );
	}
	
?>
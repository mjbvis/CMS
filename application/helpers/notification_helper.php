<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	function setNotification($type , $userID, $add = null){
		switch ($type) {
			case "waitlistAChild":
				waitlistAChild($userID, 1);
		}
	}
	
	function waitlistAChild($userID, $id){
	    mysql_query("INSERT INTO UserNotifications Value(" . $id . ",'" . $userID . "', '')");
	}
?>
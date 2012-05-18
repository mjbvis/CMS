<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	const waitlistID = 1;
	const registerAChildID = 6;
	const medicalInformationID = 7;
	const registrationCompleteID = 8;
	//const  ID = 9;
	//const  ID = 10;
	//const  ID = 11;
	//const  ID = 12;
	
	/*
	 * $type = type of notification see above
	 * $userID = sets whats user is getting the notification
	 * $urlParam = sets additional information that will be needed to generate a proper URL
	 * $additionalInfo = this is where names go if you want them in them to show up in the URL description
	 * 
	 */
	
	function setNotification($type , $userID, $urlParam = '', $additionalInfo = null){
		switch ($type) {
			case "waitlistAChild":
				set($userID, waitlistID, $urlParam, $additionalInfo);
				break;
			case "registerAChild":
				set($userID, registerAChildID, $urlParam, getChildNameFromFormID($urlParam));
				break;
			case "medicalInformation":
				set($userID, medicalInformationID, $urlParam, $additionalInfo);
				break;
			case "registrationComplete":
				set($userID, registrationCompleteID, $urlParam, $additionalInfo);
				break;
		}
	}
	
	function unsetNotification($type , $userID, $urlParam = ''){
		switch ($type) {
			case "waitlistAChild":
				delete($userID, waitlistID, $urlParam);
				break;	
			case "registerAChild":
				delete($userID, registerAChildID, $urlParam);
				break;
			case "medicalInformation":
				delete($userID, medicalInformationID, $urlParam);
				break;
			case "registrationComplete":
				delete($userID, registrationCompleteID, $urlParam);
				break;
		}		
	}
	
	function set($userID , $id, $urlParam, $additionalInfo = null){
	    mysql_query("INSERT INTO UserNotifications Value(" . $id . ",'" . $userID . "', '" . $additionalInfo . "', '" . $urlParam . "')");
	}
	
	function delete($userID, $id, $urlParam){
	    mysql_query("DELETE FROM UserNotifications WHERE UserID =" . $userID . " AND NotificationID =" . $id . " AND UrlParam ='" . $urlParam . "'" );
	}
	
	function getUserIDFromFormID($ids){
		$waitlist = Waitlist_form::find_by_formid($ids);
		$waitlistAttr = $waitlist->attributes();
        
		return $waitlistAttr['userid'];

	}

	function getUsernameFromFormID($ids){
		$UserID = getUserIDFromFormID($ids);
		
		$users = User::find_by_id($UserID);
		$usersAttr = $users->attributes();
        
		return $usersAttr['username'];

	}
	
	function getChildNameFromFormID($ids){
		$waitlistForm = Waitlist_form::find_by_formid($ids);
		$wlAttr = $waitlistForm->attributes();
		
		return $wlAttr['firstname'] . ' ' . $wlAttr['lastname'];

	}
	
	function emailParentAndLetThemKnowTheyCanRegisterAStudent($ids){
        	
		$username = getUsernameFromFormID($ids);	
			
        $query =   "SELECT Parent.FirstName, Parent.LastName, users.email 
                    FROM users
                    JOIN Parent ON (users.id = Parent.UserID)
                    WHERE users.username ='" . $username . "'";     
        
        $result = mysql_query($query);
        
        $firstName =  mysql_result($result, 0, "FirstName");
        $lastName =  mysql_result($result, 0, "LastName");
        $email =  mysql_result($result, 0, "email");	
			
			
		$to = $email;
		$subject = "New MSG from CMS for" . $firstName . ", " . $lastName;
		$body = "ATTN: " . $firstName . ", " . $lastName .  "\n\nYou can now finish enrolling your student.";
		if (mail($to, $subject, $body)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
    function getUserinfo($username){ 
        $query =   "SELECT Parent.FirstName, Parent.LastName, users.email 
                    FROM users
                    JOIN Parent ON (users.id = Parent.UserID)
                    WHERE users.username ='" . $username . "'";     
        
        $result = mysql_query($query);
        
        $info['first'] =  mysql_result($result, 0, "FirstName");
        $info['last'] =  mysql_result($result, 0, "LastName");
        $info['email'] =  mysql_result($result, 0, "email");
        
        return $info;
    }

?>
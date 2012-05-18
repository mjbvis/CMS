<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notifications extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'Notifications';
	
	# explicit pk since our pk is not "id" 
 	static $primary_key = 'NotificationID';
	
	# explicit column names for the sake of readability
	static $alias_attribute = array(
		'NotificationID' => 'NotificationID',
		'Description' => 'Description',
		'URL' => 'URL');

	static $has_many = array(
		array('user_notifications'
			 ,'class_name' => 'User_notifications'
			 ,'foreign_key' => 'notificationid'
			 ,'primary_key' => 'notificationid'
			 )
		);
}
	
	
?>
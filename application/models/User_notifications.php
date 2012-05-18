<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_notifications extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'UserNotifications';

	# explicit pk since our pk is not "id"
	# The actual table has a compound primary key
	# consisting of NotificationID, UserID, and UrlParam
 	//static $primary_key = 'NotificationID';

	# explicit column names for the sake of readability
	static $alias_attribute = array(
		'NotificationID' => 'NotificationID',
		'UserID' => 'UserID',
		'AdditionalInfo' => 'AdditionalInfo',
		'UrlParam' => 'UrlParam');

	static $belongs_to = array(
		array('notification'
			 ,'class_name' => 'Notifications'
			 ,'foreign_key' => 'notificationid'
			 ,'primary_key' => 'notificationid'
			 ),
		array('user'
			 ,'class_name' => 'User'
			 ,'foreign_key' => 'id'
			 ,'primary_key' => 'userid'
			 )
		);
}
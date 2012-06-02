<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Volunteer_log_entry extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'VolunteerLogEntry';
	
	# explicit pk since our pk is not "id" 
 	//static $primary_key = 'SubItemID';
	
	# explicit column names for the sake of readability
	static $alias_attribute = array(
		'EntryID' => 'EntryID',
		'UserID' => 'UserID',
		'Hours' => 'Hours',
		'Description' => 'Description',
		'VolunteeredDTTM' => 'VolunteeredDTTM',
		'UDTTM' => 'UDTTM');
		
	static $belongs_to = array(
		array('user'
			 ,'class_name' => 'User'
			 ,'foreign_key' => 'userid'
			 ,'primary_key' => 'id')
		);
}
	
	
?>
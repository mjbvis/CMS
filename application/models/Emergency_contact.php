<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Emergency_contact extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'EmergencyContact';
	
	# explicit pk since our pk is not "id" 
 	//static $primary_key = 'ContactID';
	
	# explicit column names for the sake of readability
	static $alias_attribute = array(
		'ContactID' => 'ContactID',
		'StudentID' => 'StudentID',
		'ECName' => 'ECName',
		'ECPhone' => 'ECPhone',
		'ECRelationship' => 'ECRelationship');
	
	static $belongs_to = array(
		array('student'
			 ,'class_name' => 'Student'
			 ,'foreign_key' => 'studentid'
			 ,'primary_key' => 'studentid'
			 )
		);
}
	
	
?>
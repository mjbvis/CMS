<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admissions_form extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'AdmissionsForm';
	
	# explicit pk since our pk is not "id" 
 	//static $primary_key = 'StudentID';
	
	# explicit column names for the sake of readability
	static $alias_attribute = array(
		'StudentID' => 'StudentID',
		'SchoolExperience' => 'SchoolExperience',
		'SocialExperience' => 'SocialExperience',
		'ComfortMethods' => 'ComfortMethods',
		'Toilet' => 'Toilet',
		'NapTime' => 'NapTime',
		'OutdoorPlay' => 'OutdoorPlay',
		'Pets' => 'Pets',
		'Interests' => 'Interests',
		'SiblingNames' => 'SiblingNames',
		'SiblingAges' => 'SiblingAges',
		'ReferrerType' => 'ReferrerType',
		'ReferredBy' => 'ReferredBy',
		'Notes' => 'Notes');
		
	static $belongs_to = array(
		array('student'
			 ,'class_name' => 'Student'
			 ,'foreign_key' => 'studentid'
			 ,'primary_key' => 'studentid')
		);
}
	
	
?>
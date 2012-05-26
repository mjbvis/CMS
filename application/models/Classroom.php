<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Classroom extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'Classroom';
	
	# explicit pk since our pk is not "id" 
 	static $primary_key = 'ClassID';
	
	# explicit column names for the sake of readability
	static $alias_attribute = array(
		'ClassID' => 'ClassID',
		'ClassName' => 'ClassName',
		'AcademicLevelID' => 'AcademicLevelID',
		'Enabled' => 'Enabled');

	static $has_many = array(
		array('interview_observation_forms'
			 ,'class_name' => 'Interview_observation_form'
			 ,'foreign_key' => 'classid'
			 ,'primary_key' => 'classid'
			 )
		);
}
	
	
?>
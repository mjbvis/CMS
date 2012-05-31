<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Program extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'Program';
	
	# explicit pk since our pk is not "id" 
 	static $primary_key = 'ProgramID';
	
	# explicit column names for the sake of readability
	static $alias_attribute = array(
		'ProgramID' => 'ProgramID',
		'AcademicYear' => 'AcademicYear',
		'AcademicLevelID' => 'AcademicLevelID',
		'Title' => 'Title',
		'Days' => 'Days',
		'StartTime' => 'StartTime',
		'EndTime' => 'EndTime',
		'Tuition' => 'Tuition',
		'Enabled' => 'Enabled');
		
	static $belongs_to = array(
		array('academic_level'
			 ,'class_name' => 'Academic_level'
			 ,'foreign_key' => 'academiclevelid'
			 ,'primary_key' => 'academiclevelid'),
		array('school_information'
			 ,'class_name' => 'School_information'
			 ,'foreign_key' => 'academicyear'
			 ,'primary_key' => 'academicyear')	
		);
}
	
	
?>
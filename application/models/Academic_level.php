<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Academic_level extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'AcademicLevel';
	
	# explicit pk since our pk is not "id" 
 	static $primary_key = 'AcademicLevelID';
	
	# explicit column names for the sake of readability
	static $alias_attribute = array(
		'AcademicLevelID' => 'AcademicLevelID',
		'AcademicLevelName' => 'AcademicLevelName',
		'Description' => 'Description',
		'Enabled' => 'Enabled');

	static $has_many = array(
		array('programs'
			 ,'class_name' => 'Program'
			 ,'foreign_key' => 'academiclevelid'
			 ,'primary_key' => 'academiclevelid'
			 )
		);
}
	
	
?>
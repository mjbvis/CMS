<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class School_information extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'SchoolInformation';
	
	# explicit pk since our pk is not "id" 
 	static $primary_key = 'AcademicYear';
	
	# explicit column names for the sake of readability
	static $alias_attribute = array(
		'AcademicYear' => 'AcademicYear',
		'ContractRenewalDeadline' => 'ContractRenewalDeadline',
		'RequiredHours' => 'RequiredHours',
		'FeePerHour' => 'FeePerHour',
		'CurrentYear' => 'CurrentYear');

	static $has_many = array(
		array('programs'
			 ,'class_name' => 'Program'
			 ,'foreign_key' => 'academicyear'
			 ,'primary_key' => 'academicyear'
			 )
		);
}
	
	
?>
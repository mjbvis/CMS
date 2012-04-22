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
		'ProgramGroupID' => 'ProgramGroupID',
		'Days' => 'Days',
		'StartTime' => 'StartTime',
		'EndTime' => 'EndTime',
		'Enabled' => 'Enabled');
		
	static $belongs_to = array(
		array('program_group'
			 ,'class_name' => 'Program_group'
			 ,'foreign_key' => 'programgroupid'
			 ,'primary_key' => 'programgroupid')
		);
}
	
	
?>
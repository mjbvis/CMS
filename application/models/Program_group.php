<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Program_group extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'ProgramGroup';
	
	# explicit pk since our pk is not "id" 
 	static $primary_key = 'ProgramGroupID';
	
	# explicit column names for the sake of readability
	static $alias_attribute = array(
		'ProgramGroupID' => 'ProgramGroupID',
		'GroupTitle' => 'GroupTitle',
		'Enabled' => 'Enabled',
		'RankOrder' => 'RankOrder');

	static $has_many = array(
		array('programs'
			 ,'class_name' => 'Program'
			 ,'foreign_key' => 'programgroupid'
			 ,'primary_key' => 'programgroupid'
			 )
		);
}
	
	
?>
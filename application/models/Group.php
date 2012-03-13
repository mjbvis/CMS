<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'group';
	
	# explicit column names for the sake of readability
	static $alias_attribute = array(
		'GroupID' => 'id',
		'Title' => 'title',
		'Description' => 'description');
	
	static $has_many = array(
		array('group_menu_item', 'class_name' => 'Group_menu_item'));
}
	
	
?>
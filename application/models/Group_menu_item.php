<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group_menu_item extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'GroupMenuItem';
	
	# explicit column names for the sake of readability
	static $alias_attribute = array(
		'GroupID' => 'GroupID',
		'MenuItemID' => 'MenuItemID');
		
	static $belongs_to = array(
		array('menu_item', 'class_name' => 'Menu_item', 'foreign_key' => 'menuitemid'),
		array('group', 'class_name' => 'Group', 'foreign_key' => 'groupid'));
}
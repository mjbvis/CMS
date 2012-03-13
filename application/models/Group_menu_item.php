<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group_menu_item extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'GroupMenuItem';
	
	# explicit column names for the sake of readability
	static $alias_attribute = array(
		'GroupID' => 'id',
		'MenuItemID' => 'MenuItemID');
		
	static $belongs_to = array(
		array('menu_item', 'class_name' => 'Menu_item'),
		array('group', 'class_name' => 'Group'));
}
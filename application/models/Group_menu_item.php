<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group_menu_item extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'GroupMenuItem';
	
	static $alias_attribute = array(
		'GroupID' => 'id',
		'MenuItemID' => 'MenuItemID');
		
	//static $belongs_to = array(
	//	'menu_item');
}
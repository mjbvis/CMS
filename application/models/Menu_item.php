<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_item extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'MenuItem';
	
	# explicit map for the sake of readability
	static $alias_attribute = array(
		'MenuItemID' => 'id',
		'Label' => 'Label',
		'URL' => 'URL');
		
	//static $has_many = array(
	//	'group_menu_item');
}
	
	
?>
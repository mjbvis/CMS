<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class menu_item extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'MenuItem';
	
	static $alias_attribute = array(
		'MenuItemID' => 'id',
		'Label' => 'Label',
		'URL' => 'URL');
		
	//static $has_many = array(
	//	'group_menu_item');
}
	
	
?>
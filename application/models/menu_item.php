<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_item extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'MenuItem';
	
	# explicit column names for the sake of readability
	static $alias_attribute = array(
		'MenuItemID' => 'id',
		'Label' => 'Label',
		'URL' => 'URL',
		'RankOrder' => 'RankOrder');
		
	static $has_many = array(
		array('sub_item', 'class_name' => 'Sub_item', 'foreign_key' => '', 'primary_key' => ''));
		//array('group_menu_item', 'class_name' => 'Group_menu_item'));
}
	
	
?>
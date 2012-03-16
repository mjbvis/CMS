<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_item extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'MenuItem';
	
	# explicit pk since our pk is not "id" 
 	static $primary_key = 'MenuItemID';
	
	# explicit column names for the sake of readability
	static $alias_attribute = array(
		'MenuItemID' => 'MenuItemID',
		'Label' => 'Label',
		'URL' => 'URL',
		'RankOrder' => 'RankOrder');
		
	static $has_many = array(
		array('sub_items'
			 ,'class_name' => 'Sub_item'
			 ,'foreign_key' => 'menuitemid'
			 ,'primary_key' => 'menuitemid'
			 ),
		array('group_menu_items' // NOTE: the many-to-many mapping through Group_menu_item.php isn't functional
			 ,'class_name' => 'Group_menu_item'
			 ,'foreign_key' => 'menuitemid'
			 ,'primary_key' => 'menuitemid'
			 ),
		array('groups'
			 ,'class_name' => 'Group'
			 ,'foreign_key' => 'groupid'
			 ,'primary_key' => 'groupid'
			 //,'through' => 'group_menu_items'
			 , array('through' => 'group_menu_items', 'foreign_key' => 'groupid')
			 )
		);
}
	
	
?>
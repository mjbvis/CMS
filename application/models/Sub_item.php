<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sub_item extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'SubItem';
	
	# explicit pk since our pk is not "id" 
 	//static $primary_key = 'SubItemID';
	
	# explicit column names for the sake of readability
	static $alias_attribute = array(
		'SubItemID' => 'SubItemID',
		'MenuItemID' => 'MenuItemID',
		'Label' => 'Label',
		'URL' => 'URL',
		'RankOrder' => 'RankOrder');
		
	static $belongs_to = array(
		array('menu_item'
			 ,'class_name' => 'Menu_item'
			 ,'foreign_key' => 'menuitemid'
			 ,'primary_key' => 'menuitemid')
		);
}
	
	
?>
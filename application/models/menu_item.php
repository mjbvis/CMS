<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class menu_item extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'MenuItem';
	
	# explicit pk
	static $primary_key = 'MenuItemID';
	
	//static $alias_attribute = array(
	//	'Label' => 'Label',
	//	'URL' => 'URL');
	
	//function get_Label() {
	//	return $this->read_attribute('Label');
    //}
}
	
	
?>
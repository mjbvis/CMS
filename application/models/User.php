<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'users';
	
	//static $primary_key = 'id';
	
	// explicit map for the sake of readability
	static $alias_attribute = array(
		'id' => 'id',
		'UserName' => 'username',
		'Email' => 'email',
		'Password' => 'password',
		'groupid' => 'group_id',
		'Token' => 'token',
		'Idenifier' => 'identifier',
		'LastLoginDTTM' => 'LastLoginDTTM',
		'CreationDTTM' => 'CreationDTTM',
		'Enabled' => 'Enabled',
		'HasChangedPassword' => 'HasChangedPassword');
		
	static $has_many = array(
		array('waitlist_forms'
			 ,'class_name' => 'Waitlist_form'
			 ,'foreign_key' => 'userid'
			 ,'primary_key' => 'id'),
 		array('parents'
			 ,'class_name' => 'Parental'
			 ,'foreign_key' => 'userid'
			 ,'primary_key' => 'userid'
			 )
		);
}

	
?>
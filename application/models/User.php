<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'users';
	
	// explicit map for the sake of readability
	static $alias_attribute = array(
		'UserID' => 'id',
		'UserName' => 'username',
		'Email' => 'email',
		'Password' => 'password',
		'GroupIdString' => 'group_id',
		'Token' => 'token',
		'Idenifier' => 'identifier',
		'LastLoginDTTM' => 'LastLoginDTTM',
		'CreationDTTM' => 'CreationDTTM',
		'Enabled' => 'Enabled',
		'HasChangedPassword' => 'HasChangedPassword');
}
	
	
?>
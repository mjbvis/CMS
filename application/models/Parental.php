<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Parental extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'Parent';
	
	// explicit map for the sake of readability
	static $alias_attribute = array(
		'ParentID' => 'id',
		'UserID' => 'UserID',
		'FirstName' => 'FirstName',
		'MiddleName' => 'MiddleName',
		'LastName' => 'LastName',
		'Email' => 'Email',
		'Employer' => 'Employer',
		'Occupation' => 'Occupation',
		'UDTTM' => 'UDTTM');
}
	
	
?>
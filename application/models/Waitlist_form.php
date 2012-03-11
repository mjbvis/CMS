<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Waitlist_form extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'WaitlistForm';
	
	// explicit map for the sake of readability
	static $alias_attribute = array(
		'FormID' => 'id',
		'ParentID' => 'ParentID',
		'FirstName' => 'FirstName',
		'LastName' => 'LastName',
		'Agreement' => 'Agreement',
		'SubmissionDTTM' => 'SubmissionDTTM');
		
	//static $has_many = array(
	//	'group_menu_item');
}
	
	
?>
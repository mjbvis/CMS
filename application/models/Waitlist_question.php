<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Waitlist_question extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'WaitlistQuestion';
	
	// explicit map for the sake of readability
	static $alias_attribute = array(
		'QuestionID' => 'id',
		'Text' => 'QuestionText',
		'Enabled' => 'Enabled',
		'UDTTM' => 'UDTTM');
		
	//static $has_many = array(
	//	'group_menu_item');
}
	
	
?>
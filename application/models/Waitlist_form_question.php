<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Waitlist_form_question extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'WaitlistFormQuestion';
	
	// explicit map for the sake of readability
	static $alias_attribute = array(
		'FormID' => 'id',
		'QuestionID' => 'QuestionID',
		'Answer' => 'Answer');
		
	//static $has_many = array(
	//	'group_menu_item');
}
	
	
?>
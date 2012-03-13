<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Waitlist_form_question extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'WaitlistFormQuestion';
	
	# explicit column names for the sake of readability
	static $alias_attribute = array(
		'FormID' => 'id',
		'QuestionID' => 'QuestionID',
		'Answer' => 'Answer');
		
	static $belongs_to = array(
		array('waitlist_question', 'class_name' => 'Waitlist_question'),
		array('waitlist_form', 'class_name' => 'Waitlist_form'));
}
	
	
?>
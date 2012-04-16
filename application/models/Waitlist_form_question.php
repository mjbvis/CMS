<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Waitlist_form_question extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'WaitlistFormQuestion';
	
	# explicit column names for the sake of readability
	static $alias_attribute = array(
		'FormID' => 'FormID',
		'QuestionID' => 'QuestionID',
		'Answer' => 'Answer');
		
	static $belongs_to = array(
		array('waitlist_question'
			 ,'class_name' => 'Waitlist_question'
			 ,'foreign_key' => 'questionid'
			 ,'primary_key' => 'questionid'),
		array('waitlist_form'
			 ,'class_name' => 'Waitlist_form'
			 ,'foreign_key' => 'formid'
			 ,'primary_key' => 'formid')
		);
}
	
	
?>
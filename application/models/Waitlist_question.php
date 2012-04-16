<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Waitlist_question extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'WaitlistQuestion';
	
	static $primary_key = 'QuestionID';

	# explicit column names for the sake of readability
	static $alias_attribute = array(
		'QuestionID' => 'QuestionID',
		'Text' => 'QuestionText',
		'Enabled' => 'Enabled',
		'UDTTM' => 'UDTTM');
		
	static $has_many = array(
		array('waitlist_form_questions'
			 ,'class_name' => 'Waitlist_form_question'
			 ,'foreign_key' => 'questionid'
			 ,'primary_key' => 'questionid'
			 ),
		array('waitlist_forms'	// NOTE: the many-to-many mapping through Waitlist_form_question.php isn't functional
			 ,'class_name' => 'Waitlist_form'
			 ,'foreign_key' => 'formid'
			 ,'primary_key' => 'formid'
			 //,'through' => 'waitlist_form_questions'
			 , array('through' => 'waitlist_form_questions', 'foreign_key' => 'formid')
			 )
		);
}
	
	
?>
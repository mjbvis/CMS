<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Waitlist_form extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'WaitlistForm';
	
	# explicit column names for the sake of readability
	static $alias_attribute = array(
		'FormID' => 'id',
		'ParentID' => 'ParentID',
		'FirstName' => 'FirstName',
		'LastName' => 'LastName',
		'Agreement' => 'Agreement',
		'SubmissionDTTM' => 'SubmissionDTTM');
		
	static $has_many = array(
		array('waitlist_questions'
			 ,'class_name' => 'Waitlist_question'
			 ,'foreign_key' => 'questionid'
			 ,'primary_key' => 'questionid'),
		array('waitlist_form'	// NOTE: the many-to-many mapping through Waitlist_form_question.php isn't functional
			 ,'class_name' => 'Waitlist_form'
			 ,'foreign_key' => 'questionid'
			 ,'primary_key' => 'questionid'
			 //,'through' => 'waitlist_form_questions'
			 , array('through' => 'waitlist_form_questions', 'foreign_key' => 'questionid')
			 )
		);
}
	
	
?>
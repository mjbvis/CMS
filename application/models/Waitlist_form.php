<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Waitlist_form extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'WaitlistForm';
	
	//static $primary_key = 'FormID';
	
	# explicit column names for the sake of readability
	static $alias_attribute = array(
		'FormID' => 'FormID',
		'UserID' => 'UserID',
		'ExpectedProgramID' => 'ExpectedProgramID',
		'FirstName' => 'FirstName',
		'MiddleName' => 'MiddleName',
		'LastName' => 'LastName',
		'Agreement' => 'Agreement',
		'SubmissionDTTM' => 'SubmissionDTTM');
		
	static $belongs_to = array(
			array('user'
			 ,'class_name' => 'User'
			 ,'foreign_key' => 'userid'
			 ,'primary_key' => 'id')
		);
		
	static $has_many = array(
		array('student'
			 ,'class_name' => 'Student'
			 ,'foreign_key' => 'questionaireid'
			 ,'primary_key' => 'formid'),
		array('waitlist_form_questions'
			 ,'class_name' => 'Waitlist_form_question'
			 ,'foreign_key' => 'formid'
			 ,'primary_key' => 'formid'),
		array('waitlist_questions'	// NOTE: the many-to-many mapping through Waitlist_form_question.php isn't functional
			 ,'class_name' => 'Waitlist_question'
			 ,'foreign_key' => 'questionid'
			 ,'primary_key' => 'questionid'
			 //,'through' => 'waitlist_form_questions'
			 , array('through' => 'waitlist_form_questions', 'foreign_key' => 'questionid')
			 )
		);
}
	
	
?>
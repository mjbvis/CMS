<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'Student';
	
	# explicit pk since our pk is not "id" 
 	static $primary_key = 'StudentID';
	
	# explicit column names for the sake of readability
	static $alias_attribute = array(
		'StudentID' => 'StudentID',
		'ClassID' => 'ClassID',
		'ProgramID' => 'ProgramID',
		'FirstName' => 'FirstName',
		'MiddleName' => 'MiddleName',
		'LastName' => 'LastName',
		'Nickname' => 'Nickname',
		'Age' => 'Age',
		'Gender' => 'Gender',
		'PlaceOfBirth' => 'PlaceOfBirth',
		'DOB' => 'DOB',
		'EnrollmentDTTM' => 'EnrollmentDTTM',
		'PhoneNumber' => 'PhoneNumber',
		'EmergencyContactID1' => 'EmergencyContactID1',
		'EmergencyContactID2' => 'EmergencyContactID2',
		'EmergencyContactID3' => 'EmergencyContactID3',
		'IsEnrolled' => 'IsEnrolled',
		'QuestionaireID' => 'QuestionaireID',
		'UDTTM' => 'UDTTM');
		
	static $belongs_to = array(
		array('waitlist_form'
			 ,'class_name' => 'Waitlist_form'
			 ,'foreign_key' => 'questionaireid'
			 ,'primary_key' => 'id'));
}
	
	
?>
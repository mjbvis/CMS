<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'Student';
	
	# explicit pk since our pk is not "id" 
 	//static $primary_key = 'StudentID';
	
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
		'Address' => 'Address',
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
		
	static $has_many = array(
		array('admissions_form'
			 ,'class_name' => 'Admissions_form'
			 ,'foreign_key' => 'studentid'
			 ,'primary_key' => 'studentid'),
		array('Student_medical'
			 ,'class_name' => 'Student_medical'
			 ,'foreign_key' => 'studentid'
			 ,'primary_key' => 'studentid')
		);
		
	static $belongs_to = array(
		array('waitlist_form'
			 ,'class_name' => 'Waitlist_form'
			 ,'foreign_key' => 'questionaireid'
			 ,'primary_key' => 'id'),
		array('emergency_contact1'
			 ,'class_name' => 'Emergency_contact'
			 ,'foreign_key' => 'emergencycontactid1'
			 ,'primary_key' => 'contactid'),
		array('emergency_contact2'
			 ,'class_name' => 'Emergency_contact'
			 ,'foreign_key' => 'emergencycontactid2'
			 ,'primary_key' => 'contactid'),
		array('emergency_contact3'
			 ,'class_name' => 'Emergency_contact'
			 ,'foreign_key' => 'emergencycontactid3'
			 ,'primary_key' => 'contactid'),
		);
}
	
	
?>
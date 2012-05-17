<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student_medical extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'StudentMedicalInformation';
	
	// explicit map for the sake of readability
	static $alias_attribute = array(
				'StudentID' => 'StudentID',
		'PreferredHospital' => 'PreferredHospital',
			'HospitalPhone' => 'HospitalPhone',
				'Physician' => 'Physician',
		   'PhysicianPhone' => 'PhysicianPhone',
		   		  'Dentist' => 'Dentist',
		   	 'DentistPhone' => 'DentistPhone',
		'MedicalConditions' => 'MedicanConditions',
			    'Allergies' => 'Allergies',
	 	 'InsuranceCompany' => 'InsuranceCompany',
		'CertificateNumber' => 'CertificateNumber',
		 	 	 'Employer' => 'Employer');
				 
				 
	static $belongs_to = array(
		array('student'
			 ,'class_name' => 'Student'
			 ,'foreign_key' => 'studentid'
			 ,'primary_key' => 'studentid')
		);
}
	
	
?>
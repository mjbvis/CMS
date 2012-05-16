<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student_medical extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'StudentMedicalInformation';
	
	// explicit map for the sake of readability
	static $alias_attribute = array(
				'StudentId' => 'StudentId',
		'PreferredHospital' => 'PreferredHospital',
			'HospitalPhone' => 'HospitalPhone',
				'Physician' => 'Physician',
		   'PhysicianPhone' => 'PhysicianPhone',
		   		  'Dentist' => 'Dentist',
		   	 'DentistPhone' => 'DentistPhone',
		'MedicalConditions' => 'MedicanConditions',
			    'Allergies' => 'Allergies');
}
	
	
?>
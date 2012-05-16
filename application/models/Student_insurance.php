<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student_insurance extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'InsuranceInformation';
	
	// explicit map for the sake of readability
	static $alias_attribute = array(
			'StudentId' => 'StudentId',
	 'InsuranceCompany' => 'InsuranceCompany',
	'CertificateNumber' => 'CertificateNumber',
		'NameOfInsured' => 'NameOfInsured',
		 	 'Employer' => 'Employer');
}
	
	
?>
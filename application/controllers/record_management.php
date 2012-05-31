<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Record_management extends Application{
	
	private static $data = array();
	
	public function __construct(){
				
		parent::__construct();
		
		/* restrict access to all but admin */
		$this->ag_auth->restrict('admin');
		
		/* Disable Cashcing */
		$this->output->nocache();
		
		/* Load helpers */
		$this->load->helper(array('url', 'menu', 'language'));
        
		/* Load libraries */
        $this->load->library('grocery_CRUD');
		
		/* setup default view data */
		$this->data['title'] = 'Record Management';
		$this->data['MenuItems'] = get_menu_items('admin');
	}
	
	# The record_management controller has no default method. Thus, the index method's job here
	# is to direct the user elsewhere.
	function index() {
		// let the login controller decide our fate
		redirect('login');
	}
	
	function manageStudents(){
		// TODO: emergency contacts need to be handled in some creative manner
		$crud = new grocery_CRUD();
		$crud->set_table('Student')
			 
			 // set up relations
			 ->set_relation('ClassID', 'Classroom', 'ClassName', array('Enabled' => '1'))
			 ->set_relation('ProgramID', 'Program', '{AcademicYear} {Title}', array('Enabled' => '1'))
			 ->set_relation('IsEnrolled','BinaryLookup','EnrolledPreenrolled')
			 
			 
			// columns for main screen (not the edit screen)
			 ->columns('FirstName', 'LastName', 'ClassID', 'Emergency Contact Info', 'PhoneNumber', 'Medical Information', 'Admissions Form', 'Waitlist Questionaire', 'IsEnrolled')
			
			// special functions for certain columns on the main screen
			 ->callback_column('Medical Information', array($this, 'getMedicalInformationLink'))
			 ->callback_column('Admissions Form', array($this, 'getAdmissionsFormLink'))
			 ->callback_column('Waitlist Questionaire', array($this, 'getWaitlistQuestionaireLink'))
			 ->callback_column('Emergency Contact Info', array($this, 'getEmergencyContactInfo'))
			 			 
			 // callbacks for the edit pages
			 ->callback_edit_field('UserID', array($this, 'getUsernameFromID'))
			 
			 // setup display alliases
			 ->display_as('FirstName', 'First Name')
			 ->display_as('MiddleName', 'Middle Name')	
			 ->display_as('LastName', 'Last Name')
			 ->display_as('PlaceOfBirth', 'Place Of Birth')
			 ->display_as('DOB', 'Date of Birth')
			 ->display_as('EnrollmentDTTM', 'Date Of Enrollment')				 			
			 ->display_as('UserID', 'Username')
			 ->display_as('ClassID', 'Classroom')
			 ->display_as('PhoneNumber', 'Phone')
			 ->display_as('EmergencyContact', 'Emergency Contacts')
			 ->display_as('ProgramID', 'Program')
			 ->display_as('EmergencyContactID1', 'Emergency Contact 1')
			 ->display_as('IsEnrolled', 'Enrollment Status')
			
			// force types
			 ->change_field_type('UserID', 'readonly')
			 ->change_field_type('Gender', 'enum', array('M','F'))
			 ->change_field_type('UDTTM', 'hidden', date('Y-m-d H:i:s', time()))
			
			 ->unset_edit_fields('EmergencyContactID1', 'EmergencyContactID2', 'EmergencyContactID3', 'QuestionaireID')
			 ->unset_add()
			 ->unset_delete();
			 
		$output = $crud->render();
		
		$this->data['preGrid'] = "<style type=\"text/css\"> h2 {text-align:center} </style><h2>Student Record Management</h2>";
				
		$this->load->view('templates/header', $this->data);
		$this->load->view('templates/fancybox_dependencies');	
		$this->load->view('templates/grid', $output);
		$this->load->view('templates/footer');
	}

	function manageAccounts(){
		$crud = new grocery_CRUD();
		
		$crud->set_table('users')
			->columns('username', 'email', 'password', 'group_id', 'Enabled', 'HasChangedPassword')
			->fields('username', 'email', 'password', 'group_id', 'Enabled', 'HasChangedPassword')
			->required_fields('username', 'email', 'password', 'group_id', 'Enabled', 'HasChangedPassword')
			
			->set_relation('Enabled','BinaryLookup','EnabledDisabled')
			->set_relation('HasChangedPassword','BinaryLookup','YesNo')
			
			// callbacks for the edit pages
			->callback_edit_field('group_id', array($this, 'getAccountType'))
			
			->display_as('group_id', 'Account Type')
			->display_as('Enabled', 'Account Status')
			->display_as('HasChangedPassword', 'Changed Password')
			
			->change_field_type('password', 'readonly')
			->unset_add();
		
    	$output = $crud->render();
		
		$this->data['preGrid'] = "<style type=\"text/css\"> h2 {text-align:center} </style><h2>Account Management</h2>";
		
		$this->load->view('templates/header', $this->data);		
		$this->load->view('templates/grid', $output);
		$this->load->view('templates/footer');
	}
	
	function managePrograms(){
		$crud = new grocery_CRUD();
		$crud->set_table('Program')
			->set_relation('AcademicLevelID', 'AcademicLevel', 'AcademicLevelName')
			->set_relation('Enabled', 'BinaryLookup', 'EnabledDisabled')
			
			->display_as('Enabled', 'Program Status')
			->display_as('AcademicYear', 'Academic Year')
			->display_as('AcademicLevelID', 'Academic Level')
			->display_as('StartTime', 'Start Time')
			->display_as('EndTime', 'End Time');

        $output = $crud->render();
		
		$this->data['preGrid'] = "<style type=\"text/css\"> h2 {text-align:center} </style><h2>Program Management</h2>";
		
		$this->load->view('templates/header', $this->data);
		$this->load->view('templates/grid', $output);
		$this->load->view('templates/footer');
	}
	
	function manageVolunteerLogs(){
		$crud = new grocery_CRUD();
		$crud->set_table('VolunteerLogEntry')
			->set_relation('UserID', 'users', 'username')
			->display_as('UserID','Username')
			->display_as('SubmissionDTTM','Date Submitted')
			->display_as('VolunteeredDTTM','Date of Activity')
			->change_field_type('UserID', 'readonly')
			
			->callback_edit_field('UserID', array($this, 'getUsernameFromID'));

        $output = $crud->render();
		
		$this->data['preGrid'] = "<style type=\"text/css\"> h2 {text-align:center} </style><h2>Volunter Log Management</h2>";
		
		$this->load->view('templates/header', $this->data);
		$this->load->view('templates/grid', $output);
		$this->load->view('templates/footer');
	}
	
	function manageProspects(){
		$crud = new grocery_CRUD();
		$crud->set_table('ProspectInterview');
		
		//set columns for main screen
		$crud->columns('ParentNames', 'ChildrenNamesAges', 'FirstContactedDTTM', 'VisitDTTM', 'PhoneNumber', 'Email', 'AppReceivedDTTM', 'FeeReceivedDTTM', 'LevelOfInterest', 'ClassID');	
			
		//set up relationships
		$crud->set_relation('ClassID','Classroom','ClassName')
			->set_relation('IsLearningIndependently','BinaryLookup','YesNo')
			->set_relation('IsLearningAtOwnPace','BinaryLookup','YesNo')
			->set_relation('IsHandsOnLearner','BinaryLookup','YesNo')
			->set_relation('IsMixedAges','BinaryLookup','YesNo')
			->set_relation('WebSearchRef','BinaryLookup','YesNo')
			->set_relation('CMSFamilyRef','BinaryLookup','YesNo')
			->set_relation('FriendsRef','BinaryLookup','YesNo')
			->set_relation('AdRef','BinaryLookup','YesNo')
			->set_relation('OtherRef','BinaryLookup','YesNo')
			->set_relation('OnTimeToObservation','BinaryLookup','YesNo')
			->set_relation('AttendedObservation','BinaryLookup','YesNo');
		
		
		// set up the aliases from column names to desired output
		$crud->display_as('ParentNames','Parent Names')
			->display_as('ChildrenNamesAges','Children Names and Ages')
			->display_as('FirstContactedDTTM','Date First Contacted')
			->display_as('VisitDTTM','Date Visited')
			->display_as('InterviewDTTM','Date Interviewed')
			->display_as('PhoneNumber','Phone Number')
			->display_as('MontessoriImpressions','Montessori Impressions')
			->display_as('InterviewImpressions','Interview Impressions')
			->display_as('LevelOfInterest','Level Of Interest')
			->display_as('LevelOfUnderstanding','Level Of Understanding')
			->display_as('WillingnessToLearn','Willingness To Learn')
			->display_as('IsLearningIndependently','Learns Independently')
			->display_as('IsLearningAtOwnPace','Learns At Own Pace')
			->display_as('IsHandsOnLearner','Hands On Learner')
			->display_as('IsMixedAges','Mixed Ages')
			->display_as('WebSearchRef','Heard of CMS from Web Search')
			->display_as('CMSFamilyRef','Heard of CMS from Family')
			->display_as('FriendsRef','Heard of CMS from Friend')
			->display_as('AdRef','Heard of CMS from Advertisment')
			->display_as('AdRefNote','Advertisment Note')
			->display_as('OtherRef','Heard of CMS from Other')
			->display_as('OtherRefNote','Other Note')
			->display_as('NewCityState','New City State')
			->display_as('NewSchool','New School')
			->display_as('ObservationDTTM','Date of Observation')
			->display_as('ClassID','Desired Classroom')
			->display_as('AttendedObservation','Attended Observation')
			->display_as('OnTimeToObservation','Was On Time To Observation')
			->display_as('AppReceivedDTTM','Date Application Received')
			->display_as('FeeReceivedDTTM','Date Fee Received');
			
			// force field types
			$crud->change_field_type('ParentNames', 'text')
				->change_field_type('ChildrenNamesAges', 'text')
				->change_field_type('MontessoriImpressions', 'text')
				->change_field_type('InterviewImpressions', 'text')
				->change_field_type('LevelOfInterest', 'enum', array('Low','Medium','High'))
				->change_field_type('LevelOfUnderstanding', 'enum', array('Little','Average','High'))
				->change_field_type('WillingnessToLearn', 'enum', array('Low','Medium','High'));

        $output = $crud->render();
		
		$this->data['preGrid'] = "<style type=\"text/css\"> h2 {text-align:center} </style><h2>Prospect Management</h2>";
		
		$this->load->view('templates/header', $this->data);
		$this->load->view('templates/grid', $output);
		$this->load->view('templates/footer');
	}

	function manageClasses(){
		$crud = new grocery_CRUD();
		$crud->set_table('Classroom')
			->display_as('Enabled', 'Is this Classroom Active')
			->set_relation('AcademicLevelID','AcademicLevel','AcademicLevelName')
			->set_relation('Enabled','BinaryLookup','YesNo');

        $output = $crud->render();
		
		$this->data['preGrid'] = "<style type=\"text/css\"> h2 {text-align:center} </style><h2>Classroom Management</h2>";
		
		$this->load->view('templates/header', $this->data);
		$this->load->view('templates/grid', $output);
		$this->load->view('templates/footer');
	}
	
	function ManageMedicalInformation($studentID) {
		$crud = new grocery_CRUD();
		$crud->set_table('StudentMedicalInformation')
	         ->change_field_type('StudentID', 'hidden', $studentID);
		$crud->where('StudentID', $studentID);
		$crud->unset_list();
		
		// TODO: fix validation.
		$crud->required_fields('PreferredHospital', 'HospitalPhone', 'Physician', 'PhysicianPhone', 'Dentist', 'DentistPhone');
		$crud->set_rules('HospitalPhone','Hospital Phone','min_length[12]');
		$crud->set_rules('PhysicianPhone','Physician Phone','min_length[12]');
		$crud->set_rules('DentistPhone','Dentist Phone','min_length[12]');
		
		$crud->display_as('PreferredHospital', 'Preferred Hospital')
			->display_as('HospitalPhone', 'Hospital Phone')
			->display_as('PhysicianPhone', 'Physician Phone')
			->display_as('DentistPhone', 'Dentist Phone')
			->display_as('MedicalConditions', 'Medical Conditions')
			->display_as('InsuranceCompany ', 'Insurance Company')
			->display_as('CertificateNumber', 'Certificate Number');
		
		
		$output = $crud->render();
				
		$this->load->view('templates/grid', $output);
	}

	function manageAdmissionsForm($studentID) {
		$crud = new grocery_CRUD();
		$crud->set_table('AdmissionsForm')
	         ->change_field_type('StudentID', 'hidden', $studentID);
		$crud->where('StudentID', $studentID);
		$crud->unset_list();
		
		// TODO: add validation
		
		$crud->display_as('SchoolExperience','School Experience')
			->display_as('SocialExperience','Social Experience')
			->display_as('ComfortMethods','Comfort Methods')
			->display_as('NapTime','Nap Time')
			->display_as('OutdoorPlay', 'Outdoor Play')
			->display_as('SiblingNames','Sibling Names')
			->display_as('SiblingAges','Sibling Ages')
			->display_as('ReferrerType','Referrer Type')
			->display_as('ReferredBy','Referred By');
		
		$output = $crud->render();
				
		$this->load->view('templates/grid', $output);
	}
	
	function getEmergencyContactInfo(){
		
	}
	
	function getUsernameFromID($value, $row){
		$user = User::find_by_id($value);
		$userAttr = $user->attributes();
		
		return $userAttr['username'];
	}
	
	function getAccountType($value, $row){
		$type = Group::find_by_id($value);
		$typeAttr = $type->attributes();
		
		return $typeAttr['title'];
	}
	
	# Callback Column for generating links to the student's Medical Information.
	function getMedicalInformationLink($value, $row) {
		$medInfo = Student_medical::find_by_studentid($row->StudentID);
		if ($medInfo != null || !empty($medInfo)) {
			return '<a class=\'fancyframe\' href="' . base_url('record_management/manageMedicalInformation/edit/' . $row->StudentID) . '" target="_blank">' . 'Medical Information' . '</a>';
		}
		return;
	}
	
	# Callback Column for generating links to the student's Admissions Form.
	function getAdmissionsFormLink($value, $row) {
		$form = Admissions_form::find_by_studentid($row->StudentID);
		if ($form != null || !empty($form)) {
			return '<a class=\'fancyframe\' href="' . base_url('record_management/manageAdmissionsForm/edit/' . $row->StudentID) . '" target="_blank">' . 'Admissions Form' . '</a>';
		}
	}
	
	# Callback Column for generating links to the student's Admissions Form.
	function getWaitlistQuestionaireLink($value, $row) {
		return '<a href="' . base_url() . '" target="_blank">' . 'Waitlist Questionaire' . '</a>';
	}
	
	function encrypt_password_callback($post_array) {
		$post_array['password'] = $this->ag_auth->salt($post_array['password']);
		return $post_array;
	}
			
}
	
/* End of file: record_management.php */
/* Location: application/controllers/record_management.php */ 
		
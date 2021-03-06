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
			 ->columns('FirstName', 'LastName', 'ClassID', 'Emergency Contacts', 'PhoneNumber', 'Medical Information', 'Admissions Form', 'Waitlist Questionaire', 'IsEnrolled')
			 // edit fields
			 ->edit_fields('UserID', 'FirstName', 'MiddleName', 'LastName', 'ProgramID', 'ClassID', 'Gender', 'Address', 'PhoneNumber', 'PlaceOfBirth', 'DOB', 'EnrollmentDTTM', 'IsEnrolled', 'UDTTM')
			
			 // special functions for certain columns on the main screen
			 ->callback_column('Medical Information', array($this, 'getMedicalInformationLink'))
			 ->callback_column('Admissions Form', array($this, 'getAdmissionsFormLink'))
			 ->callback_column('Waitlist Questionaire', array($this, 'getWaitlistQuestionaireLink'))
			 ->callback_column('Emergency Contacts', array($this, 'getEmergencyContactLink'))
			 			 
			 // callbacks for the edit pages
			 ->callback_edit_field('UserID', array($this, 'getUsernameFromID'))
			 ->callback_edit_field('UDTTM', array($this, 'getFieldAsReadonly'))
			 
			 // call back after updates
			 ->callback_after_update(array($this, 'updateStudentDateTime'))
			 
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
			 ->display_as('ProgramID', 'Program')
			 ->display_as('EmergencyContactID1', 'Emergency Contact 1')
			 ->display_as('IsEnrolled', 'Enrollment Status')
			 ->display_as('UDTTM', 'Last Modified')
			
			// force types
			 ->change_field_type('UserID', 'readonly')
			 ->change_field_type('Gender', 'enum', array('M','F'))
			 			 
			 // Custom Action
			 ->add_action('test', base_url().'assets/images/remove.png', 'record_management/removeFromPreEnrolled')
		
			 ->required_fields('FirstName', 'LastName', 'ProgramID', 'Address', 'PhoneNumber', 'PlaceOfBirth', 'DOB', 'IsEnrolled')
			 // TODO: figure out how to validate Dates in grocery crud. Using the valid_date rule
			 //		  doesn't work because the integer is converted to a bazaar date before validation occurs.
			 //->set_rules('DOB', 'Date of Birth', 'required|valid_date')
			 
			 ->unset_edit_fields('QuestionaireID')
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
			->display_as('EndTime', 'End Time')

			->required_fields('Enabled', 'AcademicYear', 'AcademicLevelID', 'StartTime', 'EndTime', 'Tuition', 'Title', 'Days');

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
			 
			 // fields to show up in edit
			 ->edit_fields('UserID', 'Hours', 'Description', 'VolunteeredDTTM', 'UDTTM')
			 
			 ->display_as('UserID','Username')
			 ->display_as('UDTTM','Date Updated')
			 ->display_as('VolunteeredDTTM','Date of Activity')
			 
			 ->change_field_type('UserID', 'readonly')
			
			 ->callback_edit_field('UDTTM', array($this, 'getFieldAsReadonly'))
			 ->callback_edit_field('UserID', array($this, 'getUsernameFromID'))
			 
			 ->callback_after_update(array($this, 'updateLogEntryDateTime'))
			 
			 ->required_fields('Hours', 'Description', 'VolunteeredDTTM');

			 $crud->unset_add();

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
			 ->display_as('ChildrenNamesAges','Children Names/Ages')
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
			 ->display_as('ClassID','Observation Classroom')
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
			 ->change_field_type('WillingnessToLearn', 'enum', array('Low','Medium','High'))

			 ->required_fields('ParentNames', 'ChildrenNamesAges');

        $output = $crud->render();
		
		$this->data['preGrid'] = "<style type=\"text/css\"> h2 {text-align:center} </style><h2>Prospect Management</h2>";
		
		$this->load->view('templates/header', $this->data);
		$this->load->view('templates/grid', $output);
		$this->load->view('templates/footer');
	}

	function manageClasses(){
		$crud = new grocery_CRUD();
		$crud->set_table('Classroom')

			 ->set_relation('AcademicLevelID','AcademicLevel','AcademicLevelName')
			 ->set_relation('Enabled','BinaryLookup','YesNo')
			 
			 ->display_as('ClassName', 'Classroom')
			 ->display_as('AcademicLevelID', 'Academic Level')
			 ->display_as('Enabled', 'Is Classroom Active')
			 
			 ->required_fields('ClassName', 'AcademicLevelID', 'Enabled');

        $output = $crud->render();
		
		$this->data['preGrid'] = "<style type=\"text/css\"> h2 {text-align:center} </style><h2>Classroom Management</h2>";
		
		$this->load->view('templates/header', $this->data);
		$this->load->view('templates/grid', $output);
		$this->load->view('templates/footer');
	}
	
	function manageMedicalInformation($studentID) {
		$crud = new grocery_CRUD();
		$crud->set_table('StudentMedicalInformation');
	    $crud->where('StudentID', $studentID);
		$crud->unset_list();
		
		$crud->callback_edit_field('StudentID', array($this, 'getNameFromStudentID'));
		
		// TODO: fix validation.
		$crud->required_fields('PreferredHospital', 'HospitalPhone', 'Physician', 'PhysicianPhone', 'Dentist', 'DentistPhone');
		$crud->set_rules('HospitalPhone','Hospital Phone','min_length[12]');
		$crud->set_rules('PhysicianPhone','Physician Phone','min_length[12]');
		$crud->set_rules('DentistPhone','Dentist Phone','min_length[12]');
		
		$crud->display_as('PreferredHospital', 'Preferred Hospital')
			->display_as('StudentID', 'Name')
			->display_as('HospitalPhone', 'Hospital Phone')
			->display_as('PhysicianPhone', 'Physician Phone')
			->display_as('DentistPhone', 'Dentist Phone')
			->display_as('MedicalConditions', 'Medical Conditions')
			->display_as('InsuranceCompany ', 'Insurance Company')
			->display_as('CertificateNumber', 'Certificate Number');
			
		$crud->change_field_type('MedicalConditions', 'text')
			->change_field_type('Allergies', 'text');
		
		
		$output = $crud->render();
				
		$this->load->view('templates/grid', $output);
	}

	function manageAdmissionsForm($studentID) {
		$crud = new grocery_CRUD();
		$crud->set_table('AdmissionsForm');
	    $crud->where('StudentID', $studentID);
		$crud->unset_list();
		
		$crud->callback_edit_field('StudentID', array($this, 'getNameFromStudentID'));
		
		// set up aliases	
		$crud->display_as('SchoolExperience','School Experience')
			->display_as('SocialExperience','Social Experience')
			->display_as('ComfortMethods','Comfort Methods')
			->display_as('NapTime','Nap Time')
			->display_as('StudentID','Name')
			->display_as('OutdoorPlay', 'Outdoor Play')
			->display_as('SiblingNames','Sibling Names')
			->display_as('SiblingAges','Sibling Ages')
			->display_as('ReferrerType','Referrer Type')
			->display_as('ReferredBy','Referred By')
		
			->required_fields('ReferrerType', 'Interests');
		
		$crud->change_field_type('SchoolExperience', 'enum', array('yes','no'))
			->change_field_type('SocialExperience', 'enum', array('yes','no'))
			->change_field_type('ComfortMethods', 'enum', array('yes','no'))
			->change_field_type('Toilet', 'enum', array('yes','no'))
			->change_field_type('NapTime', 'enum', array('yes','no'))
			->change_field_type('OutdoorPlay', 'enum', array('yes','no'))
			->change_field_type('Notes', 'text');
		
		$output = $crud->render();
				
		$this->load->view('templates/grid', $output);
	}

	function manageWaitlistForm($studentID) {
		$crud = new grocery_CRUD();
		$crud->set_table('AdmissionsForm');
	    $crud->where('StudentID', $studentID);
		$crud->unset_list();
		
		$crud->callback_edit_field('StudentID', array($this, 'getNameFromStudentID'));
		
		// set up aliases	
		$crud->display_as('StudentID','Name')
			 ->display_as('SchoolExperience','School Experience')
			 ->display_as('SocialExperience','Social Experience')
			 ->display_as('ComfortMethods','Comfort Methods')
			 ->display_as('NapTime','Nap Time')
			 ->display_as('OutdoorPlay','Outdoor Play')
			 ->display_as('SiblingNames','Sibling Names')
			 ->display_as('SiblingAges','Sibling Ages')
			 ->display_as('ReferrerType','Referrer Type')
			 ->display_as('ReferredBy','Referred By');
			
		// force fields
		$crud->change_field_type('Notes', 'text');
		
		$output = $crud->render();
				
		$this->load->view('templates/grid', $output);
	}
	
	function manageSubMenuItems(){
		$crud = new grocery_CRUD();
		$crud->set_table('SubItem')
			->set_relation('MenuItemID', 'MenuItem', 'Label');
			
	    		
		$output = $crud->render();
				
		$this->load->view('templates/header', $this->data);		
		$this->load->view('templates/grid', $output);
		$this->load->view('templates/footer');
	}
	
	function manageParentMenuItems(){
		$crud = new grocery_CRUD();
		$crud->set_table('MenuItem');
	    		
		$output = $crud->render();
				
		$this->load->view('templates/header', $this->data);		
		$this->load->view('templates/grid', $output);
		$this->load->view('templates/footer');
	}
	
	function manageGroupMenuItems(){
		$crud = new grocery_CRUD();
		$crud->set_table('GroupMenuItem')
			->set_relation('GroupID','groups','title')
			->set_relation('MenuItemID','MenuItem','Label');
	    		
		$output = $crud->render();
				
		$this->load->view('templates/header', $this->data);		
		$this->load->view('templates/grid', $output);
		$this->load->view('templates/footer');
	}
	
	function manageEmergencyContacts(){
		$crud = new grocery_CRUD();
		$crud->set_table('EmergencyContact')
			 ->set_relation('StudentID','Student','{FirstName} {LastName}');
			
		//set up aliases
		$crud->display_as('StudentID','Student Name')
			 ->display_as('ECName','Contact Name')
			 ->display_as('ECPhone','Phone')
			 ->display_as('ECRelationship','Relationship')
	    		
			 ->required_fields('ECName', 'ECPhone', 'ECRelationship');
			 
		$output = $crud->render();
				
		$this->load->view('templates/header', $this->data);		
		$this->load->view('templates/grid', $output);
		$this->load->view('templates/footer');
	}
	
		# This is the grocery crud for a parents' students' emergency contacts.
	function manageStudentEmergencyContacts($studentID){
		try{
			// verify that student exists and belongs to the current parent
			$student = Student::find_by_studentid($studentID);
			if($student == null)
				throw new Exception('The specified student could not be found: ' . $studentID);
		}
		catch(ActiveRecord\ActiveRecordException $e){
			// TODO: handle gracefully
			throw $e;
		}
		catch(Exception $e){
			// TODO: handle gracefully
			printf($e->getMessage());
			return $e;
		}
		$crud = new grocery_CRUD();
		$crud->set_table('EmergencyContact')		
	         ->columns('ECName', 'ECPhone', 'ECRelationship')
			 
			 ->display_as('StudentID', 'Student')
			 ->display_as('ECName', 'Name')
			 ->display_as('ECPhone', 'Phone')
			 ->display_as('ECRelationship', 'Relationship')
			 
			 ->callback_edit_field('StudentID', array($this, 'getNameFromStudentID'))
			 
			 ->required_fields('ECName', 'ECPhone', 'ECRelationship')
			 
			 ->unset_edit_fields('ContactID')
			 ->unset_add();
		
		$crud->where('StudentID', $studentID);
		
        $output = $crud->render();
		
		$this->load->view('templates/grid', $output);
	}	
	
	function getUsernameFromID($value, $row){
		$user = User::find_by_id($value);
		$userAttr = $user->attributes();
		
		return $userAttr['username'];
	}
	
	# Callback Column for generating links to the student's Emergency Contacts.
	function getEmergencyContactLink($value, $row){
		$contact = Emergency_contact::find_by_studentid($row->StudentID);
		if($contact != null || !empty($contact))
			return '<a class=\'smallfancyframe\' href="' . base_url('record_management/manageStudentEmergencyContacts/' . $row->StudentID) . '" target="_blank">' . 'Emergency Contacts' . '</a>';
		return;
	}
	
	function getNameFromStudentID($value, $row){
		$name = Student::find_by_studentid($value);
		$nameAttr = $name->attributes();
		
		$string = '<span class="callbackLabel">' . $nameAttr['firstname'] . ' ' . $nameAttr['lastname'] . '</span>';
		
		return $string;
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
		// this magically works TODO mark make sure this is right
		return '<a class=\'fancyframe\' href="' . base_url('record_management/manageWaitlistForm/edit/' . $row->StudentID) . '" target="_blank">' . 'Waitlist Questionaire' . '</a>';
	}
	
	# Callback edit field that displays a field as a readonly label
	function getFieldAsReadonly($value, $row){
		return '<label>' . $value . '</label>';
	}
	
	function encrypt_password_callback($post_array) {
		$post_array['password'] = $this->ag_auth->salt($post_array['password']);
		return $post_array;
	}
	
	# callback function for the manageVolunteeLogs grocery crud.
	# updates the log entry's update datetime upon update.
	function updateLogEntryDateTime($post_array, $entryid){
		$entry = Volunteer_log_entry::find_by_entryid($entryid);
		if($entry == null)
			return null;
		$entry->udttm = date('Y-m-d H:i:s', time());
		$entry->save();
	}
	
	# callback function for the manageStudents grocery crud.
	# updates the student's update datetime upon update.
	function updateStudentDateTime($post_array, $studentid){
		$student = Student::find_by_studentid($studentid);
		if($student == null)
			return null;
		$student->udttm = date('Y-m-d H:i:s', time());
		$student->save();
	}
	
	
	function removeFromPreEnrolled(){
		
	}		
}
	
/* End of file: record_management.php */
/* Location: application/controllers/record_management.php */ 
		
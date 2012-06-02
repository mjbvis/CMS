<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Parents extends Application {

	private static $data = array();

	function __construct() {
		parent::__construct();

		/*restrict access to all but parents*/
		$this->ag_auth->restrict('parent');
		
		/* Disable Cashcing */
		$this->output->nocache();

		/* Load helpers */
		$this->load->helper(array('url', 'form', 'menu', 'language'));

		/* Load libraries */
        $this->load->library('grocery_CRUD');

		/* setup default view data */
		$this->data['title'] = 'Parent Dashboard';
		$this->data['MenuItems'] = get_menu_items('parent');
	}

	function index() {
		
		if(logged_in())
		{
			/* load views */
			$this->load->view('templates/header', $this->data);
			$this->load->view('templates/fancybox_dependencies');
			$this->load->view('parents/dashboard', $this->data);
			$this->load->view('templates/footer');
		}
		else {
			$this->login();
		}
	}

	# The grocery crud for waitlisted students belonging
	# to the current user. This grid is dedicated for viewing.
	# Adds, Edits, and Deletes should not be allowed.
	function waitlistGrid() {
		$crud = new grocery_CRUD();
		$crud->set_table('WaitlistForm')
	         ->columns('FirstName', 'LastName')
			 ->display_as('FirstName', 'First')
			 ->display_as('LastName', 'Last')
			 ->unset_operations();
			 
		$crud->where('UserID', user_id());
		$crud->where('IsWaitlisted', 1);
		$crud->where('IsPreEnrolled', 0);
				
		$output = $crud->render();
		
		$this->load->view('templates/grid', $output);
	}

	# The grocery crud for pre-enrolled students belonging
	# to the current user. This grid is dedicated for viewing.
	# Adds, Edits, and Deletes should not be allowed.
	function preEnrolledGrid() {
		$crud = new grocery_CRUD();
		$crud->set_table('WaitlistForm')
	         ->columns('FirstName', 'LastName')
			 ->display_as('FirstName', 'First')
			 ->display_as('LastName', 'Last')
			 ->unset_operations();

		$crud->where('UserID', user_id());
		$crud->where('IsWaitlisted', 0);
		$crud->where('IsPreEnrolled', 1);

        $output = $crud->render();
		$this->load->view('templates/grid', $output);
	}

	# The grocery crud for the registered students belonging
	# to the current user. This grid is dedicated for viewing.
	# Adds, Edits, and Deletes should not be allowed.
	function registeredGrid() {
		$crud = new grocery_CRUD();
		$crud->set_table('Student')
	         ->columns('FirstName', 'LastName')
			 ->display_as('FirstName', 'First')
			 ->display_as('LastName', 'Last')
			 ->unset_operations();
			 
		// make sure that the child is only considered registered after they have filled out their
		// StudentMedicalInformation form.
		$crud->where('UserID', user_id());
		$crud->where('Student.StudentID IN (SELECT StudentMedicalInformation.StudentID
											FROM StudentMedicalInformation
											WHERE StudentMedicalInformation.StudentID = Student.StudentID)');
		
        $output = $crud->render();
		$this->load->view('templates/grid', $output);
	}

	# This function produces a non editable grid of the volunteer log table
	function volunteeringGrid() {
		
		$crud = new grocery_CRUD();
		$crud->set_table('VolunteerLogEntry')
	         ->columns('Hours', 'Description', 'VolunteeredDTTM')
			 ->display_as('VolunteeredDTTM', 'Date of Activity')
			 ->display_as('Description', 'Task')
			 ->unset_operations();
		
		$crud->where('UserID', user_id());
		
        $output = $crud->render();
		$this->load->view('templates/grid', $output);
	}


	# The grocery crud for the current user's notifications. This grid is dedicated
	# for viewing. Adds, Edits, and Deletes should not be allowed.
	function notificationGrid() {		 
		$crud = new grocery_CRUD();
		$crud->set_table('UserNotifications')
			 ->set_relation('NotificationID', 'Notifications', 'Description')
			 ->columns('UrlParam')
			 ->display_as('UrlParam', 'Description')
			 ->callback_column('UrlParam', array($this, 'get_notification_URL'))
			 ->unset_operations();
			 
		$crud->where('UserID', user_id());

        $output = $crud->render();

		$this->load->view('templates/grid', $output);
	}
	
	# Callback Column for notifications.
	# We want to construct a link so that the user can click it to resolve the notification.
	function get_notification_URL($value, $row) {
		$notification = Notifications::find_by_notificationid($row->NotificationID);
		$NotificationAttr = $notification->attributes();
		return '<a id="fancyframe" href="' . base_url($NotificationAttr['url'] . $row->UrlParam) . '" target="_blank">' . $NotificationAttr['description'] . $row->AdditionalInfo . '</a>';
	}
	
	# grocery crud for parents to log volunteer hours. They should be able to add. They
	# should be able to delete. They should not be able to edit.
	function manageMyVolunteerActivity(){
		// This is the one plus the maximum number of hours that can be logged in a single log entry
		$max_hours = 9;
		
		$crud = new grocery_CRUD();
		$crud->set_table('VolunteerLogEntry')
	         ->columns('Hours', 'Description', 'VolunteeredDTTM')
			 
			 ->display_as('UDTTM', 'Date/Time')
			 ->display_as('VolunteeredDTTM', 'Date of Activity')
			 ->display_as('Description', 'Task')
			 
			 ->add_fields('UserID', 'Hours', 'Description', 'UDTTM', 'VolunteeredDTTM')
			 
			 ->required_fields('UserID', 'Hours', 'Description', 'UDTTM', 'VolunteeredDTTM')
			 
			 ->change_field_type('UserID', 'hidden', user_id())
			 ->change_field_type('UDTTM', 'hidden', date('Y-m-d H:i:s', time()))
			 
			 ->callback_after_update(array($this, 'updateDateTime'))
			 
			 ->unset_edit_fields('UDTTM');
		
		$crud->where('UserID', user_id());
		
		$crud->set_rules('Hours','Hours','numeric|less_than[' . $max_hours . ']');
		$crud->set_rules('Description', 'required');
		
		$this->data['preGrid'] = "<style type=\"text/css\"> h2 {text-align:center} </style><h2>Volunter Log Management</h2>";
		
        $output = $crud->render();
		$this->load->view('templates/header', $this->data);
		
		$this->load->view('templates/grid', $output);
		$this->load->view('templates/footer');
	}
	
	# grocery crud for Parents to manage their students. They
	# should not be able to add. They should have partial ability to edit.
	function manageMyStudents(){
		$crud = new grocery_CRUD();
		$crud->set_table('Student')
		
	         ->columns('FirstName', 'LastName', 'Admissions Form', 'Medical Information', 'Emergency Contact')
			 
			 ->display_as('FirstName', 'First')
			 ->display_as('MiddleName', 'Middle')
			 ->display_as('LastName', 'Last')
			 ->display_as('ClassID', 'Classroom')
			 ->display_as('ProgramID', 'Program')
			 ->display_as('PlaceOfBirth', 'Place Of Birth')
			 ->display_as('DOB', 'Date of Birth')
			 ->display_as('PhoneNumber', 'Phone')
			 
			 ->change_field_type('UserID', 'hidden', user_id())
			 ->change_field_type('Gender', 'enum', array('M','F'))
			 
			 ->callback_column('Medical Information', array($this, 'getMedicalInformationLink'))
			 ->callback_column('Admissions Form', array($this, 'getAdmissionsFormLink'))
			 
			 ->callback_edit_field('ProgramID', array($this, 'getProgram'))
			 ->callback_edit_field('ClassID', array($this, 'getClassroom'))
			 ->callback_column('Emergency Contact', array($this, 'emergencyContactLink'))
			 
			 ->callback_after_update(array($this, 'updateDateTime'));
			 
		$crud->required_fields('FirstName', 'LastName', 'Address', 'PlaceOfBirth', 'PhoneNumber');
		$crud->set_rules('PhoneNumber', 'PhoneNumber', 'min_length[12]');
		// TODO: figure out how to validate Dates in grocery crud. Using the valid_date rule
		//		 doesn't work because the integer is converted to a bazaar date before validation occurs.
		$crud->set_rules('DOB', 'Date of Birth', 'required|valid_date');

		$crud->unset_edit_fields('QuestionaireID', 'EnrollmentDTTM', 'IsEnrolled', 'UDTTM')
			 ->unset_add();
			 
		// make sure that the child is only considered registered after they have filled out their
		// StudentMedicalInformation form.
		$crud->where('UserID', user_id());
		$crud->where('Student.StudentID IN (SELECT StudentMedicalInformation.StudentID
											FROM StudentMedicalInformation
											WHERE StudentMedicalInformation.StudentID = Student.StudentID)');
		
        $output = $crud->render();
		
		$this->data['preGrid'] = "<style type=\"text/css\"> h2 {text-align:center} </style><h2>My Student Management</h2>";
		
		$this->load->view('templates/header', $this->data);
		$this->load->view('templates/fancybox_dependencies');
		$this->load->view('templates/grid', $output);
		$this->load->view('templates/footer');
	}
	
	# callback function for the manageMyStudent grocery crud. The parent
	# should not be allowed to edit their program, so it needs to be readonly
	function getProgram($value, $row){
		$program = Program::find_by_programid($value);
		if($program == null)
			return '<label></label>';
		$programAttr = $program->attributes();
		
		return '<label>' . $programAttr['title'] . '</label>';
	}

	# callback function for the manageMyStudent grocery crud. The parent
	# should not be allowed to edit their classroom, so it needs to be readonly
	function getClassroom($value, $row){
		$classroom = Classroom::find_by_classid($value);
		if($classroom == null)
			return;
		$classroomAttr = $classroom->attributes();
		
		return '<label>' . $classroomAttr['classname'] . '</label>';
	}

	# callback function for the manageMyStudent grocery crud.
	# updates the student's update datetime upon update.
	function updateStudentDateTime($post_array, $studentid){
		$student = Student::find_by_studentid($studentid);
		if($student == null)
			return null;
		$student->updatedttm = date('Y-m-d H:i:s', time());
		$student->save();
	}
	
	# Callback Column for generating links to the student's Emergency Contacts.
	function emergencyContactLink($value, $row){
		$contact = Emergency_contact::find_by_studentid($row->StudentID);
		if($contact != null || !empty($contact))
			return '<a class=\'smallfancyframe\' href="' . base_url('parents/manageMyEmergencyContacts/' . $row->StudentID) . '" target="_blank">' . 'Emergency Contacts' . '</a>';
		return;
	}
	
	# Callback Column for generating links to the student's Medical Information.
	function getMedicalInformationLink($value, $row) {
		$medInfo = Student_medical::find_by_studentid($row->StudentID);
		if ($medInfo != null || !empty($medInfo)) {
			return '<a class=\'fancyframe\' href="' . base_url('parents/manageMyMedicalInformation/edit/' . $row->StudentID) . '" target="_blank">' . 'Medical Information' . '</a>';
		}
		return;
	}
	
	# Callback Column for generating links to the student's Admissions Form.
	function getAdmissionsFormLink($value, $row) {
		$form = Admissions_form::find_by_studentid($row->StudentID);
		if ($form != null || !empty($form)) {
			return '<a class=\'fancyframe\' href="' . base_url('parents/manageMyAdmissionsForm/edit/' . $row->StudentID) . '" target="_blank">' . 'Admissions Form' . '</a>';
		}
	}

	# This is the grocery crud for a parents' students' emergency contacts.
	function manageMyEmergencyContacts($studentID){
		try{
			// verify that student exists and belongs to the current parent
			$student = Student::find_by_studentid($studentID);
			if($student == null)
				throw new Exception('The specified student could not be found: ' . $studentID);
			$studentAttr = $student->attributes();
			if($studentAttr['userid'] != user_id())
				throw new Exception('Access Denied.');
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
			 
			 ->display_as('ECName', 'Name')
			 ->display_as('ECPhone', 'Phone')
			 ->display_as('ECRelationship', 'Relationship')
			 
			 ->callback_edit_field('StudentID', array($this, 'getnameFromStudentID'))
			 
			 ->required_fields('ECName', 'ECPhone', 'ECRelationship')
			 
			 ->unset_edit_fields('ContactID')
			 ->unset_add();
		
		$crud->where('StudentID', $studentID);
		
        $output = $crud->render();
		
		$this->load->view('templates/grid', $output);
	}

	# grocery crud for managing a student's medical information.
	# NOTE: the $edit parameter just eats the '/edit' input.
	function manageMyMedicalInformation($edit, $studentID) {		
		try{
			// verify that student exists and belongs to the current parent
			$student = Student::find_by_studentid($studentID);
			if($student == null)
				throw new Exception('The specified student could not be found: ' . $studentID);
			$studentAttr = $student->attributes();
			if($studentAttr['userid'] != user_id())
				throw new Exception('Access Denied.');
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
		$crud->set_table('StudentMedicalInformation')
	    	 
			 ->display_as('PreferredHospital', 'Preferred Hospital')
			 ->display_as('StudentID', 'Name')
			 ->display_as('HospitalPhone', 'Hospital Phone')
			 ->display_as('PhysicianPhone', 'Physician Phone')
			 ->display_as('DentistPhone', 'Dentist Phone')
			 ->display_as('MedicalConditions', 'Medical Conditions')
			 ->display_as('InsuranceCompany ', 'Insurance Company')
			 ->display_as('CertificateNumber', 'Certificate Number')
			
			 ->change_field_type('MedicalConditions', 'text')
			 ->change_field_type('Allergies', 'text')
		
			 ->callback_edit_field('StudentID', array($this, 'getnameFromStudentID'))
		
			 ->required_fields('PreferredHospital', 'HospitalPhone', 'Physician', 'PhysicianPhone', 'Dentist', 'DentistPhone')
			 ->set_rules('HospitalPhone','Hospital Phone','min_length[12]')
			 ->set_rules('PhysicianPhone','Physician Phone','min_length[12]')
			 ->set_rules('DentistPhone','Dentist Phone','min_length[12]')
		
			 ->where('StudentID', $studentID);
		
			 $crud->unset_list();
		
		$output = $crud->render();
				
		$this->load->view('templates/grid', $output);
	}

	# grocery crud for managing a student's medical information.
	# NOTE: the $edit parameter just eats the '/edit' input.
	function manageMyAdmissionsForm($edit, $studentID) {
		try{
			// verify that student exists and belongs to the current parent
			$student = Student::find_by_studentid($studentID);
			if($student == null)
				throw new Exception('The specified student could not be found: ' . $studentID);
			$studentAttr = $student->attributes();
			if($studentAttr['userid'] != user_id())
				throw new Exception('Access Denied.');
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
		$crud->set_table('AdmissionsForm')
	    	 
			 ->callback_edit_field('StudentID', array($this, 'getnameFromStudentID'))
		
			 // set up aliases	
			 ->display_as('SchoolExperience','School Experience')
			 ->display_as('SocialExperience','Social Experience')
			 ->display_as('ComfortMethods','Comfort Methods')
			 ->display_as('NapTime','Nap Time')
			 ->display_as('StudentID','Name')
			 ->display_as('OutdoorPlay', 'Outdoor Play')
			 ->display_as('SiblingNames','Sibling Names')
			 ->display_as('SiblingAges','Sibling Ages')
			 ->display_as('ReferrerType','Referrer Type')
			 ->display_as('ReferredBy','Referred By')
		
			 ->change_field_type('SchoolExperience', 'enum', array('yes','no'))
			 ->change_field_type('SocialExperience', 'enum', array('yes','no'))
			 ->change_field_type('ComfortMethods', 'enum', array('yes','no'))
			 ->change_field_type('Toilet', 'enum', array('yes','no'))
			 ->change_field_type('NapTime', 'enum', array('yes','no'))
			 ->change_field_type('OutdoorPlay', 'enum', array('yes','no'))
			 ->change_field_type('Notes', 'text')
			 ->change_field_type('Interests')
			 
			 ->required_fields('PreferredHospital', 'HospitalPhone', 'Physician', 'PhysicianPhone', 'Dentist', 'DentistPhone')
			 ->set_rules('HospitalPhone','Hospital Phone','min_length[12]')
			 ->set_rules('PhysicianPhone','Physician Phone','min_length[12]')
			 ->set_rules('DentistPhone','Dentist Phone','min_length[12]')
			 
			 ->where('StudentID', $studentID);
			 
			 $crud->unset_list();
		
		$output = $crud->render();
				
		$this->load->view('templates/grid', $output);
	}

	function getnameFromStudentID($value, $row){
		$name = Student::find_by_studentid($value);
		$nameAttr = $name->attributes();
		
		$string = $nameAttr['firstname'] . ' ' . $nameAttr['lastname'];
		
		return $string;
	}

}
?>
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
			 
			 // set up 1-n relations
			 ->set_relation('UserID', 'users', 'username')
			 ->set_relation('ClassID', 'Classroom', 'ClassName', array('Enabled' => '1'))
			 ->set_relation('ProgramID', 'Program', '{Days}, {StartTime} - {EndTime}')
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
			 			
			 ->display_as('UserID', 'Username')
			 ->display_as('ClassID', 'Classroom')
			 ->display_as('PhoneNumber', 'Phone')
			 ->display_as('EmergencyContact', 'Emergency Contacts')
			 ->display_as('ProgramID', 'Program')
			 ->display_as('EmergencyContactID1', 'Emergency Contact 1')
			 ->display_as('IsEnrolled', 'Enrollment Status')
			
			 ->change_field_type('UserID', 'readonly')
			 ->change_field_type('Gender', 'enum', array('M','F'))
			 ->change_field_type('UDTTM', 'hidden', date('Y-m-d H:i:s', time()))
			
			 ->unset_edit_fields('EmergencyContactID1', 'EmergencyContactID2', 'EmergencyContactID3', 'QuestionaireID')
			 ->unset_add()
			 ->unset_delete();
			 
		$output = $crud->render();
		
		$this->data['preGrid'] = "<style type=\"text/css\"> h2 {text-align:center} </style><h2>Student Record Management</h2>";
				
		$this->load->view('templates/header', $this->data);		
		$this->load->view('templates/grid', $output);
		$this->load->view('templates/footer');
	}

	function manageAccounts(){
		$crud = new grocery_CRUD();
		
		$crud->set_table('users')
			->columns('username', 'email', 'password', 'group_id', 'Enabled', 'HasChangedPassword');
		
		$crud->fields('username', 'email', 'password', 'group_id', 'Enabled', 'HasChangedPassword');
		$crud->required_fields('username', 'email', 'password', 'group_id', 'Enabled', 'HasChangedPassword');
		
		//$crud->change_field_type('password', 'password');
     	$crud->callback_before_update(array($this,'encrypt_password_callback'));
		$crud->callback_before_insert(array($this,'encrypt_password_callback'));
		
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
			
			->display_as('Enabled', 'Program Status');

        $output = $crud->render();
		
		$this->data['preGrid'] = "<style type=\"text/css\"> h2 {text-align:center} </style><h2>Program Management</h2>";
		
		$this->load->view('templates/header', $this->data);
		$this->load->view('templates/grid', $output);
		$this->load->view('templates/footer');
	}
	
	function manageVolunteerLogs(){
		$crud = new grocery_CRUD();
		$crud->set_table('VolunteerLogEntry')
			->set_relation('UserID', 'users', 'username');

        $output = $crud->render();
		
		$this->data['preGrid'] = "<style type=\"text/css\"> h2 {text-align:center} </style><h2>Volunter Log Management</h2>";
		
		$this->load->view('templates/header', $this->data);
		$this->load->view('templates/grid', $output);
		$this->load->view('templates/footer');
	}
	
	function manageProspects(){
		$crud = new grocery_CRUD();
		$crud->set_table('ProspectInterview');

        $output = $crud->render();
		
		$this->data['preGrid'] = "<style type=\"text/css\"> h2 {text-align:center} </style><h2>Prospect Management</h2>";
		
		$this->load->view('templates/header', $this->data);
		$this->load->view('templates/grid', $output);
		$this->load->view('templates/footer');
	}
	
		function getEmergencyContactInfo(){
		
	}
	
	function getUsernameFromID($value, $row){
		$user = User::find_by_id($value);
		$userAttr = $user->attributes();
		
		return $userAttr['username'];
	}
	
	# Callback Column for generating links to the student's Medical Information.
	function getMedicalInformationLink($value, $row) {
		$medInfo = Student_medical::find_by_studentid($row->StudentID);
		if ($medInfo != null || !empty($medInfo)) {
			return '<a href="' . base_url('admin/medicalInformationGrid/edit/' . $row->StudentID) . '" target="_blank">' . 'Medical Information' . '</a>';
		}
		return;
	}
	
	# Callback Column for generating links to the student's Admissions Form.
	function getAdmissionsFormLink($value, $row) {
		$form = Admissions_form::find_by_studentid($row->StudentID);
		if ($form != null || !empty($form)) {
			return '<a href="' . base_url('admin/admissionsFormGrid/edit/' . $row->StudentID) . '" target="_blank">' . 'Admissions Form' . '</a>';
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
	
	function fancyBoxTest(){
		$this->load->view('test/dashboard');
	}
	
}
	
/* End of file: record_management.php */
/* Location: application/controllers/record_management.php */ 
		
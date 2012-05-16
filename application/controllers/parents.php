<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Parents extends Application {

	private static $data = array();

	function __construct() {
		parent::__construct();

		/*restrict access to all but parents*/
		$this->ag_auth->restrict('parent');

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
			$this->load->view('parents/dashboard', $this->data);
			$this->load->view('templates/footer');
		}
		else {
			$this->login();
		}
	}

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

	function registeredGrid() {
		$crud = new grocery_CRUD();
		$crud->set_table('Student')
	         ->columns('FirstName', 'LastName')
			 ->display_as('FirstName', 'First')
			 ->display_as('LastName', 'Last')
			 ->unset_operations();
			 
		$crud->where('UserID', user_id());
		
        $output = $crud->render();
		$this->load->view('templates/grid', $output);
	}

	function volunteeringGrid() {
		
		// This is the maximum number of hours that can be logged in a single log entry
		$max_hours = 8;
		
		$crud = new grocery_CRUD();
		$crud->set_table('VolunteerLogEntry')
	         ->columns('SubmissionDTTM', 'Hours', 'Description')
			 ->display_as('SubmissionDTTM', 'Date/Time')
			 ->display_as('Description', 'Task')
			 ->add_fields('UserID', 'Hours', 'Description', 'SubmissionDTTM')
			 ->required_fields('UserID', 'Hours', 'Description', 'SubmissionDTTM')
			 ->unset_edit()
			 ->unset_delete();
			 
		$crud->callback_add_field('UserID', array($this, 'get_user_id'));
		$crud->callback_add_field('SubmissionDTTM', array($this, 'get_current_datetime'));
		
		$crud->where('UserID', user_id());
		
		$crud->set_rules('Hours','Hours','numeric|less_than[' . $max_hours . ']');
		$crud->set_rules('Description', 'required');
		
        $output = $crud->render();
		$this->load->view('templates/grid', $output);
	}

	function get_user_id() {
		return '<input type="text" maxlength="50" value="' . user_id() . '" name="UserID" style="width:400px" readonly="true">';
	}
	
	function get_current_datetime() {
		$curr_datetime = date('Y-m-d H:i:s', time());

		return '<input type="text" maxlength="50" value="' . $curr_datetime . '" name="SubmissionDTTM" style="width:400px" readonly="true">';
	}
}
?>
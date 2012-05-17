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
			 
		$crud->where('UserID', user_id());
		
        $output = $crud->render();
		$this->load->view('templates/grid', $output);
	}

	# The volunteering grocery crud for the parent dashboard. This
	# grid should have Add enabled but Edit and Delete disabled. Parent's
	# should not be able to edit and/or delete their volunteer logs. It
	# should only show log entries for the current user.
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
		
		# Use these callback fields to make UserID and SubmissionDTTM readonly
		# with default values.
		$crud->callback_add_field('UserID', array($this, 'get_user_id'));
		$crud->callback_add_field('SubmissionDTTM', array($this, 'get_current_datetime'));
		
		$crud->where('UserID', user_id());
		
		$crud->set_rules('Hours','Hours','numeric|less_than[' . $max_hours . ']');
		$crud->set_rules('Description', 'required');
		
        $output = $crud->render();
		$this->load->view('templates/grid', $output);
	}


	# The grocery crud for the current user's notifications. This grid is dedicated
	# for viewing. Adds, Edits, and Deletes should not be allowed.
	function notificationGrid() {

		$crud = new grocery_CRUD();
		$crud->set_table('Notifications')
			 ->set_relation('NotificationID', 'UserNotifications', 'UserID')
	         ->columns('Description')
			 ->display_as('NotificationID', 'UserID')
			 ->callback_column('Description', array($this, 'get_notification_URL'))
			 ->unset_operations();
			 
		$crud->where('UserID', user_id());

        $output = $crud->render();
		
		$this->load->view('templates/grid', $output);
	}

	# Callback Add Field for the UserID.
	# We want a the UserID to be readonly and set to the current user's id. This
	# function adds the UserID to the add form of a grocery crud.
	function get_user_id() {
		return '<input type="text" maxlength="50" value="' . user_id() . '" name="UserID" style="width:400px" readonly="true">';
	}
	
	# Callback Add Field for the SubmissionDTTM.
	# We want a the SubmissionDTTM to be readonly and set to the current datetime.
	# This function adds the SubmissionDTTM to the add form of a grocery crud.
	function get_current_datetime() {
		$curr_datetime = date('Y-m-d H:i:s', time());
		return '<input type="text" maxlength="50" value="' . $curr_datetime . '" name="SubmissionDTTM" style="width:400px" readonly="true">';
	}
	
	# Callback Add Field for the SubmissionDTTM.
	# We want a the SubmissionDTTM to be readonly and set to the current datetime.
	# This function adds the SubmissionDTTM to the add form of a grocery crud.
	function get_notification_URL($value, $row) {
		return '<a href="' . base_url($row->URL) . '" target="_blank">' . $row->Description . '</a>';
	}
}
?>
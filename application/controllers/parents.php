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
			 ->change_field_type('UserID', 'hidden', user_id())
			 ->change_field_type('SubmissionDTTM', 'hidden', date('Y-m-d H:i:s', time()))
			 ->unset_edit()
			 ->unset_delete();
		
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
		return '<a href="' . base_url($NotificationAttr['url'] . $row->UrlParam) . '" target="_blank">' . $NotificationAttr['description'] . $row->AdditionalInfo . '</a>';
	}
}
?>
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

		/* setup default view data */
		$this->data['title'] = 'Parent Dashboard';
		$this->data['MenuItems'] = get_menu_items('parent');
	}

	function index() {
		
		if(logged_in())
		{
			/* load views */
			$this->home();
		}
		else {
			$this->login();
		}
		
	}

	function home($wlGrid= 'none', $preEnrollGrid = 'none', $registeredGrid = 'none', $volunteeringGrid = 'none') {
		# $wlGrid - the waitlist table
		$columns = array(
			0 => array(
				'name' => 'cFname',
				'db_name' => 'FirstName',
				'header' => 'First Name',
				'group' => 'Child',
				'required' => TRUE,
				'unique' => TRUE,
				'form_control' => 'text_long',
				'type' => 'string'),
			1 => array(
				'name' => 'cLname',
				'db_name' => 'LastName',
				'header' => 'First Name',
				'group' => 'Child',
				'required' => FALSE,
				'visible' => TRUE,
				'form_control' => 'text_long',
				'type' => 'string'),
			2 => array(
				'name' => 'preEnrolled',
				'db_name' => 'IsPreEnrolled',
				'header' => 'Pre-enrolled',
				'group' => 'Child',
				'allow_filter' => FALSE,
                'visible' => FALSE,
                'form_control' => 'checkbox',
                'type' => 'boolean'),
			3 => array(
				'name' => 'waitlisted',
				'db_name' => 'IsWaitlisted',
				'header' => 'Waitlisted',
				'group' => 'Child',
				'allow_filter' => FALSE,
                'visible' => FALSE,
                'form_control' => 'checkbox',
                'type' => 'boolean'),
            4 => array(
				'name' => 'userid',
				'db_name' => 'UserID',
				'header' => 'UserID',
				'group' => 'Child',
				'allow_filter' => FALSE,
                'visible' => FALSE,
                'form_control' => 'text_short',
                'type' => 'integer')
		);
		      
		$params = array(
			'id' => 'preEnrolledForm',
			'table' => 'WaitlistForm',
			'table_id_name' => 'FormID',
			'url' => 'parents/home',
			'uri_param' => $wlGrid,
			'params_after' => $preEnrollGrid,
			'columns' => $columns,
			'hard_filters' => array(
                2 => array('value' => FALSE)
			   ,3 => array('value' => TRUE)
			   ,4 => array('value' => user_id())
            ),
			'allow_add' => FALSE,
            'allow_edit' => FALSE,
            'allow_delete' => FALSE,
            'allow_select' => FALSE,
            'allow_filter' => FALSE,
            'allow_columns' => FALSE,
            'allow_page_size' => FALSE,
			'nested' => FALSE,
			'ajax' => TRUE,
			'show_empty_rows' => FALSE,
			
		);
		
		$this->load->library('carbogrid', $params, 'wlGrid');
 
        if ($this->wlGrid->is_ajax)
        {
            $this->wlGrid->render();
            return FALSE;
        }
		
		# preEnrollGrid - the pre-enrolled table
		$columns = array(
			0 => array(
				'name' => 'cFname',
				'db_name' => 'FirstName',
				'header' => 'First Name',
				'group' => 'Child',
				'required' => TRUE,
				'unique' => TRUE,
				'form_control' => 'text_long',
				'type' => 'string'),
			1 => array(
				'name' => 'cLname',
				'db_name' => 'LastName',
				'header' => 'First Name',
				'group' => 'Child',
				'required' => FALSE,
				'visible' => TRUE,
				'form_control' => 'text_long',
				'type' => 'string'),
			2 => array(
				'name' => 'preEnrolled',
				'db_name' => 'IsPreEnrolled',
				'header' => 'Pre-enrolled',
				'group' => 'Child',
				'required' => FALSE,
				'visible' => FALSE,
				'form_control' => 'checkbox',
				'type' => 'string'),
			3 => array(
				'name' => 'waitlisted',
				'db_name' => 'IsWaitlisted',
				'header' => 'Waitlisted',
				'group' => 'Child',
				'allow_filter' => FALSE,
                'visible' => FALSE,
                'form_control' => 'checkbox',
                'type' => 'boolean'),
            4 => array(
				'name' => 'userid',
				'db_name' => 'UserID',
				'header' => 'UserID',
				'group' => 'Child',
				'allow_filter' => FALSE,
                'visible' => FALSE,
                'form_control' => 'text_short',
                'type' => 'integer')
		);
		      
		$params = array(
			'id' => 'waitlistForm',
			'table' => 'WaitlistForm',
			'table_id_name' => 'FormID',
			'url' => 'parents/home',
			'uri_param' => $preEnrollGrid,
			'params_before' => $wlGrid,
			'columns' => $columns,
			'hard_filters' => array(
                2 => array('value' => TRUE)
			   ,3 => array('value' => FALSE)
			   ,4 => array('value' => user_id())
            ),
			'allow_add' => FALSE,
            'allow_edit' => FALSE,
            'allow_delete' => FALSE,
            'allow_select' => FALSE,
            'allow_filter' => FALSE,
            'allow_columns' => FALSE,
            'allow_page_size' => FALSE,
			'nested' => FALSE,
			'ajax' => TRUE,
			'show_empty_rows' => FALSE,
			
		);
		
		$this->load->library('carbogrid', $params, 'preEnrollGrid');
 
        if ($this->preEnrollGrid->is_ajax)
        {
            $this->preEnrollGrid->render();
            return FALSE;
        }		
 
 		# registered students - the student table
		$columns = array(
			0 => array(
				'name' => 'cFname',
				'db_name' => 'FirstName',
				'header' => 'First Name',
				'group' => 'Child',
				'required' => TRUE,
				'unique' => TRUE,
				'form_control' => 'text_long',
				'type' => 'string'),
			1 => array(
				'name' => 'cLname',
				'db_name' => 'LastName',
				'header' => 'First Name',
				'group' => 'Child',
				'required' => FALSE,
				'visible' => TRUE,
				'form_control' => 'text_long',
				'type' => 'string'),
            2 => array(
				'name' => 'userid',
				'db_name' => 'UserID',
				'header' => 'UserID',
				'group' => 'Child',
				'allow_filter' => FALSE,
                'visible' => FALSE,
                'form_control' => 'text_short',
                'type' => 'integer')
		);
		      
		$params = array(
			'id' => 'registeredForm',
			'table' => 'Student',
			'table_id_name' => 'StudentID',
			'url' => 'parents/home',
			'uri_param' => $registeredGrid,
			'params_before' => $preEnrollGrid,
			'columns' => $columns,
			'hard_filters' => array(
				2 => array('value' => user_id())
            ),
			'allow_add' => FALSE,
            'allow_edit' => FALSE,
            'allow_delete' => FALSE,
            'allow_select' => FALSE,
            'allow_filter' => FALSE,
            'allow_columns' => FALSE,
            'allow_page_size' => FALSE,
			'nested' => FALSE,
			'ajax' => TRUE,
			'show_empty_rows' => FALSE,
			
		);
		
		$this->load->library('carbogrid', $params, 'registeredGrid');
 
        if ($this->registeredGrid->is_ajax)
        {
            $this->registeredGrid->render();
            return FALSE;
        }
 
  		# voluteer log entries - the VolunteerLogEntry table
		$columns = array(
			0 => array(
				'name' => 'datetime',
				'db_name' => 'SubmissionDTTM',
				'header' => 'DateTime',
				'group' => 'Volunteer Log Entry',
				'required' => TRUE,
				'visible' => TRUE,
				'form_control' => 'datetimepicker',
				'type' => 'datetime'),
			1 => array(
				'name' => 'hours',
				'db_name' => 'Hours',
				'header' => 'Hours',
				'group' => 'Volunteer Log Entry',
				'required' => TRUE,
				'visible' => TRUE,
				'form_control' => 'text_short',
				'type' => 'string'),
			2 => array(
				'name' => 'event',
				'db_name' => 'EventID',
				'header' => 'Event',
				'group' => 'Volunteer Log Entry',
				'ref_table_db_name' => 'Event',
				'ref_field_db_name' => 'EventName',
				'ref_field_type' => 'string',
				'ref_table_id_name' => 'EventID',
				'required' => FALSE,
				'visible' => TRUE,
				'form_control' => 'dropdown',
				'type' => '1-n'),
			3 => array(
				'name' => 'description',
				'db_name' => 'Description',
				'header' => 'Task',
				'group' => 'Volunteer Log Entry',
				'required' => TRUE,
				'visible' => TRUE,
				'form_visible' => TRUE,
				'form_control' => 'text_long',
				'type' => 'string'),
            4 => array(
				'name' => 'userid',
				'db_name' => 'UserID',
				'header' => 'UserID',
				'group' => 'Volunteer Log Entry',
				'form_default' => user_id(),
                'visible' => FALSE,
                'form_visible' => FALSE,
                'form_control' => 'text_short',
                'type' => 'integer'),
		);
		      
		$params = array(
			'id' => 'volunteeringForm',
			'table' => 'VolunteerLogEntry',
			'table_id_name' => 'EntryID',
			'url' => 'parents/home',
			'uri_param' => $volunteeringGrid,
			'params_before' => $registeredGrid,
			'columns' => $columns,
			'hard_filters' => array(
			   4 => array('value' => user_id())
            ),
			'allow_add' => TRUE,
            'allow_edit' => FALSE,
            'allow_delete' => FALSE,
            'allow_select' => FALSE,
            'allow_filter' => FALSE,
            'allow_columns' => FALSE,
            'allow_page_size' => FALSE,
			'nested' => FALSE,
			'ajax' => FALSE,
			'show_empty_rows' => FALSE,
			
		);
		
		$this->load->library('carbogrid', $params, 'volunteeringGrid');
 
        if ($this->volunteeringGrid->is_ajax)
        {
            $this->volunteeringGrid->render();
            return FALSE;
        }

        // Pass grid to the view
        $viewData['wlGrid'] = $this->wlGrid->render();
		$viewData['preEnrollGrid'] = $this->preEnrollGrid->render();
		$viewData['registeredGrid'] = $this->registeredGrid->render();
 		$viewData['volunteeringGrid'] = $this->volunteeringGrid->render();
 
		$this->load->view('templates/header', $this->data);
		$this->load->view('parents/dashboard', $viewData);
		$this->load->view('templates/footer');
	}
}
?>
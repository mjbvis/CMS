<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Application{
	
	private static $data = array();
	
	public function __construct(){
				
		parent::__construct();
		
		/* restrict access to all but admin */
		$this->ag_auth->restrict('admin');
		
		/* Load helpers */
		$this->load->helper(array('url', 'form', 'registration', 'menu', 'language' , 'notification'));
        
		/* Load libraries */
        $this->load->library('Repositories/Registration_Repository', '', 'reg');
		$this->load->library('grocery_CRUD');
		
		/* setup default view data */
		$this->data['title'] = 'Admin Dashboard';
		$this->data['MenuItems'] = get_menu_items('admin');
	}
	
	public function index(){
		
		// Main function called when this controller is loaded		
		if(logged_in()){
				
		//* load views */
		$this->load->view('templates/header', $this->data);		
		$this->load->view('admin/dashboard');
		$this->load->view('templates/footer');
			
		}
		else{
			$this->login();
		}
	}
	
	function manageStudents(){
		$this->load->view('templates/header', $this->data);		
		$this->load->view('admin/record_management/manage_students');
		$this->load->view('templates/footer');
	}
	
	function studentGrid(){
		$crud = new grocery_CRUD();
		$crud->set_table('Student');
		$output = $crud->render();
		$this->load->view('templates/grid', $output);
	}
	
	function studentEducBackgroundGrid(){
		$crud = new grocery_CRUD();
		$crud->set_table('StudentEduBackground');
		$output = $crud->render();
		$this->load->view('templates/grid', $output);
	}
	
	function studentMedicalInformationGrid(){
		$crud = new grocery_CRUD();
		$crud->set_table('StudentMedicalInformation');
		$output = $crud->render();
		$this->load->view('templates/grid', $output);
	}
	
	function manageAccounts(){
		//this is so we can add more grids using iframes
		// hopefully soon grocery CRUD supports multiple tables with out using iframes in 1 view soon	
		$this->manActGrid();
	}
	
	function manActGrid(){
		$crud = new grocery_CRUD();
		
		$crud->set_table('users')
			->columns('username', 'email', 'password', 'group_id', 'Enabled', 'HasChangedPassword');
		
		$crud->fields('username', 'email', 'password', 'group_id', 'Enabled', 'HasChangedPassword');
		$crud->required_fields('username', 'email', 'password', 'group_id', 'Enabled', 'HasChangedPassword');
		
		//$crud->change_field_type('password', 'password');
     	$crud->callback_before_update(array($this,'encrypt_password_callback'));
		$crud->callback_before_insert(array($this,'encrypt_password_callback'));
		
    	$output = $crud->render();
		$this->load->view('templates/header', $this->data);		
		$this->load->view('templates/grid', $output);
		$this->load->view('templates/footer');
	}

	function encrypt_password_callback($post_array) {
		$post_array['password'] = $this->ag_auth->salt($post_array['password']);
		return $post_array;
	}        

	
	// grids for the dashboard
	function waitlistGrid(){
			
		$crud = new grocery_CRUD();
			
		$crud->set_table('WaitlistForm')
			->columns('FirstName', 'LastName')
			->display_as('FirstName', 'First')
			->display_as('LastName','Last')
			->unset_operations();
		
		$crud->where('IsWaitlisted', 1);	
		
    	$output = $crud->render();
		$this->load->view('templates/grid',$output);
	}

	function preEnrolledGrid(){
		
		$crud = new grocery_CRUD();
		
		$crud->set_table('WaitlistForm')
			->columns('FirstName', 'LastName')
			->display_as('FirstName', 'First')
			->display_as('LastName','Last')
			->unset_operations();
		
		$crud->where('IsPreEnrolled', 1);
		
    	$output = $crud->render();
		$this->load->view('templates/grid',$output);
	}
	
	function volunteerLogGrid(){
			
		$crud = new grocery_CRUD();
		
		$crud->set_table('VolunteerLogEntry')
			->set_relation('UserID', 'users', 'username')
			->columns('UserID', 'Hours', 'Description', 'SubmissionDTTM')
			->display_as('SubmissionDTTM', 'Date Submitted')
			->display_as('UserID', 'Username')
			->unset_operations();
		
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
		
		//$this->output->enable_profiler(TRUE);//Turns on CI debugging
		
		$this->load->view('templates/grid', $output);
	}
	// end grids for dashboard
	
	# Callback Add Field for the SubmissionDTTM.
	# We want a the SubmissionDTTM to be readonly and set to the current datetime.
	# This function adds the SubmissionDTTM to the add form of a grocery crud.
	function get_notification_URL($value, $row) {
		return '<a href="' . base_url($row->URL) . '" target="_blank">' . $row->Description . '</a>';
	}
	
	// this function is for creating a new account for parents
	function addParentUserAccount(){
		$this->form_validation->set_rules('first', 'First Name', 'required|min_length[1]');
        $this->form_validation->set_rules('last', 'Last Name', 'required|min_length[1]');
        //$this->form_validation->set_rules('middle', 'Middle Name', '');
        $this->form_validation->set_rules('email', 'Email Address', 'required|min_length[3]|valid_email|callback_field_exists');

		if($this->form_validation->run() == FALSE){
			$this->load->view('templates/header', $this->data);	
			$this->load->view('admin/register/add_parent_user');
			$this->load->view('templates/footer');
		}
		else{
			$firstName = set_value('first');
            //$middleName = set_value('middle');
            $lastName = set_value('last');
			$username = $firstName . '.' . $lastName;
            
            //check db to make sure this is a unique name
            // if not add a number and try again
            if (!$this->reg->isUsernameUnique($username)){
                $isUnique = FALSE; 
                $i = 1;
                while (!$isUnique) {         
                    $i = $i + 1;
                    $isUnique = $this->reg->isUsernameUnique($username . '.'. $i);
                }
                $username = $username . '.'. $i;
            }
            
            $plainTextPassword = generatePassword();
            
			// encrypt the password
			$password = $this->ag_auth->salt($plainTextPassword);
			$email = set_value('email');

			if($this->ag_auth->register($username, $password, $email) === TRUE){
				sendNewUserAccountCreationEmail($firstName, $lastName, $email, $username, $plainTextPassword);
                
                $this->data['firstName'] = $firstName;
                $this->data['lastName'] = $lastName;
                $this->data['email'] = $email;
                $this->data['username'] = $username;
                $this->data['plainTextPassword'] = $plainTextPassword;
                
                $this->load->view('templates/header', $this->data);  
                $this->load->view('admin/register/success' , $this->data);
                $this->load->view('templates/footer');
				
			} 
			else{
				echo "Error";
			}
            
			$newUserAttr = User::find_by_username($username)->attributes();
            $userId = $newUserAttr['id'];
                  
            $this->createParent($userId, $firstName, $middleName, $lastName, $email);
			setNotification('waitlistAChild', $userId);
             //$this->output->enable_profiler(TRUE);//Turns on CI debugging
		} 
	}

	// This is the Interview/Observation form that the administrator
	// fills out for the parent.
	function interviewObservationForm(){
	    $this->load->view('templates/header', $this->data);  
        $this->load->view('admin/interview_observation');
        $this->load->view('templates/footer');
	}

	// Saves the interview and observation form that the admin fills out.
	function storeInterviewObservationForm(){
		$data = array(
			'pFirst' 		=> set_value('pFirstName'),
			'pLast' 		=> set_value('pLastName'),
			'cFirst' 		=> set_value('cFirstName'),
			'cLast'		 	=> set_value('cLastName'),
			'cAge' 			=> set_value('cAgeName'),
			'dob' 			=> set_value('dobName'),
			'contactDate' 	=> set_value('contactDateName'),
			'phone' 		=> set_value('phoneName'),
			'visitDate' 	=> set_value('visitDateName'),
			'email'		 	=> set_value('emailName'),
			'learnedAbout'  => set_value('learnedAboutName'),
			'adIn'			=> set_value('adInName'),
			'other'			=> set_value('otherName'),
			'interest'		=> set_value('interestName'),
			'understanding' => set_value('understandingName'),
			'willingness'	=> set_value('willingnessName'),
			'movingCity'	=> set_value('movingCityName'),
			'movingState'	=> set_value('movingStateName'),
			'movingSchool'	=> set_value('movingSchoolName'),
			'learningNotes' => set_value('learningNotesName'),
			'montessoriImp' => set_value('montessoriImpressionsName'),
			'interviewImp'	=> set_value('interviewImpressionsName'),
			'obervationDate'=> set_value('observationDateName'),
			'classroom'		=> set_value('classroomName'),
			'attended'  	=> set_value('attendedName'),
			'onTime'		=> set_value('onTimeName'),
			'interviewDate' => set_value('interviewDateName'),
			'appReceived' 	=> set_value('appReceivedName'),
			'feeReceived'	=> set_value('feeReceivedName')
		);
		return $data;
	}

	// Sets the validation rules for the InterviewObservationForm
	function validateInterviewObservationForm(){
		$this->form_validation->set_rules('pFirstName', 'Parent\'s First Name', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('pLastName', 'Parent\'s Last Name', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('cFirstName', 'Child\'s First Name', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('cLastName', 'Child\'s Last Name', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('cAgeName', 'Child\'s Age', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('dobName', 'Date of Birth', 'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('contactDateName', 'Contact Date', 'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('phoneName', 'Phone Number', 'required|min_length[10]|callback_field_exists');
		$this->form_validation->set_rules('visitDateName', 'Visit Date', 'required|min_length[10]|callback_field_exists');
		$this->form_validation->set_rules('emailName', 'Email', 'required|min_length[5]|callback_field_exists');
		$this->form_validation->set_rules('learnedAboutName', 'Learned About CMS How', 'required');
		$this->form_validation->set_rules('interestName', 'Level of Interest', 'required');
		$this->form_validation->set_rules('understandingName', 'Understanding of Montessori', 'required');
		$this->form_validation->set_rules('willingnessName', 'Willingness to learn more', 'required');
		$this->form_validation->set_rules('movingCityName', 'Moving City', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('movingStateName', 'Moving State', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('movingSchoolName', 'Moving School', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('montessoriImpressionsName', 'Montessori Impressions', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('interviewImpressionsName', 'Interviews Impressions', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('observationDateName', 'Classroom Obersvation Date', 'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('classroomName', 'Classroom Observed', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('attendedName', 'Attended', 'required');
		$this->form_validation->set_rules('onTimeName', 'On Time', 'required');
		$this->form_validation->set_rules('interviewDateName', 'Interview Date', 'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('appReceivedName', 'Date Application Received', 'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('feeReceivedName', 'Date Application Fee Received', 'required|min_length[4]|callback_field_exists');
	}

    function createParent($userId, $fName, $mName, $lName, $email){
        $parent = new Parental();
        $parent->userid = $userId;
        $parent->firstname = $fName;
        $parent->middlename = $mName;
        $parent->lastname = $lName;
        $parent->email = $email;
        $parent->uddtm = date('Y-m-d H:i:s', time());
        $parent->save();
    }
    
    // dev function for creating new menu items
    // this function will not be used in final prod
    function addSubItem(){

        $this->form_validation->set_rules('menuItemID', 'menuItemID', 'required');
        $this->form_validation->set_rules('label', 'label', 'required');
        $this->form_validation->set_rules('URL', 'URL', 'required');
        $this->form_validation->set_rules('rankOrder', 'rankOrder', 'required');

        if($this->form_validation->run() == FALSE){
            $this->load->view('templates/header', $this->data);  
            $this->load->view('admin/menu/add_menu_item');
            $this->load->view('templates/footer');
        }
        else{
        
        $menuItemID = set_value('menuItemID');
        $label = set_value('label');
        $URL = set_value('URL');
        $rankOrder = set_value('rankOrder');
                
        $query = "INSERT INTO SubItem (MenuItemID, Label, URL, RankOrder) VALUES (" . $menuItemID . ", '" . $label . "', '" . $URL . "', " . $rankOrder . ")";
        $result = mysql_query($query);
        
        redirect('admin');        
		}
    }
	
	function waitlist($grid1 = 'none', $grid2 = 'none') {
			
	    if ($this->input->post('moveToEnrolled')){
            // cg_preEnrolledForm_item_ids is a var auto made from cg
            // the preEnrolledForm is from the 'id' => 'preEnrolledForm',
            // item_ids i belive referes to 'table_id_name' => 'FormID',
            $ids = $this->input->post('cg_preEnrolledForm_item_ids');
 
            if (count($ids)){
                //TODO: This should be in a model of course
                $this->db->set('IsWaitlisted', 0)->where_in('FormID', $ids)->update('WaitlistForm');
				$this->db->set('IsPreEnrolled', 1)->where_in('FormID', $ids)->update('WaitlistForm');
								
				foreach ($ids as $id) {
					setNotification('registerAChild' , getUserIDFromFormID($id), '', $id);
					emailParentAndLetThemKnowTheyCanRegisterAStudent($id);
				}
				
            }
        }
        if ($this->input->post('moveToWaitlist')){
            $ids = $this->input->post('cg_WaitlistForm_item_ids');
 
            if (count($ids)){
                //TODO This should be in a model of course
                $this->db->set('IsWaitlisted', 1)->where_in('FormID', $ids)->update('WaitlistForm');
				$this->db->set('IsPreEnrolled', 0)->where_in('FormID', $ids)->update('WaitlistForm');
				
				foreach ($ids as $id) {
					unsetNotification('registerAChild' , getUserIDFromFormID($id), '',  $id);
				}
				
            }
        }	
			  	
		//grid1 - the waitlist table
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
                'type' => 'boolean')
		);
		      
		$params = array(
			'id' => 'preEnrolledForm',
			'table' => 'WaitlistForm',
			'table_id_name' => 'FormID',
			'url' => 'admin/waitlist',
			'uri_param' => $grid1,
			'params_after' => $grid2,
			'columns' => $columns,
			
			'hard_filters' => array(
                2 => array('value' => FALSE)
			   ,3 => array('value' => TRUE)
            ),
			
			'allow_add' => FALSE,
            'allow_edit' => FALSE,
            'allow_delete' => FALSE,
            'allow_filter' => FALSE,
            'allow_columns' => FALSE,
            'allow_page_size' => FALSE,
			
			'nested' => TRUE,
			'ajax' => TRUE,
			
		);
		
		$this->load->library('carbogrid', $params, 'grid1');
 
        if ($this->grid1->is_ajax)
        {
            $this->grid1->render();
            return FALSE;
        }
 
		//grid2 - the pre-enrolled table
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
                'type' => 'boolean')
		);
		      
		$params = array(
			'id' => 'WaitlistForm',
			'table' => 'WaitlistForm',
			'table_id_name' => 'FormID',
			'url' => 'admin/waitlist',
			'uri_param' => $grid2,
			'params_before' => $grid1,
			'columns' => $columns,
			
			'hard_filters' => array(
                2 => array('value' => TRUE)
			   ,3 => array('value' => FALSE)
            ),
			
			'allow_add' => FALSE,
            'allow_edit' => FALSE,
            'allow_delete' => FALSE,
            'allow_filter' => FALSE,
            'allow_columns' => FALSE,
            'allow_page_size' => FALSE,
			
			'nested' => TRUE,
			'ajax' => TRUE,
			
		);
		
		$this->load->library('carbogrid', $params, 'grid2');
 
        if ($this->grid2->is_ajax)
        {
            $this->grid2->render();
            return FALSE;
        }		
 

        // Pass grid to the view     
        $data->grid1 = $this->grid1->render();
		$data->grid2 = $this->grid2->render();
 
    	$this->load->view('templates/header', $this->data);  
		$this->load->view('admin/record_management/waitlist_management', $data);
		$this->load->view('templates/footer');
    }

}

/* End of file: dashboard.php */
/* Location: application/controllers/admin/dashboard.php */
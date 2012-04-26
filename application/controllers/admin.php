<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Application{
	
	private static $data = array();
	
	public function __construct(){
				
		parent::__construct();
		
		/* restrict access to all but admin */
		$this->ag_auth->restrict('admin');
		
		/* Load helpers */
		$this->load->helper(array('url', 'form', 'registration', 'menu', 'language'));
        
		/* Load libraries */
        $this->load->library('Repositories/Registration_Repository', '', 'reg');
		
		/* setup default view data */
		$this->data['title'] = 'Admin Dashboard';
		$this->data['MenuItems'] = get_menu_items('admin');
	}
	
	public function index(){
				
		if(logged_in()){				
			/* load views */
			$this->load->view('templates/header', $this->data);
			$this->load->view('admin/dashboard', $this->data);
			$this->load->view('templates/footer', $this->data);
		}
		else{
			$this->login();
		}
	}
	
	public function register(){
		$this->form_validation->set_rules('first', 'First Name', 'required|min_length[1]|callback_field_exists');
        $this->form_validation->set_rules('last', 'Last Name', 'required|min_length[1]|callback_field_exists');
        $this->form_validation->set_rules('middle', 'Middle Name', '');
        $this->form_validation->set_rules('email', 'Email Address', 'required|min_length[3]|valid_email|callback_field_exists');

		if($this->form_validation->run() == FALSE){
			$this->load->view('templates/header', $this->data);	
			$this->load->view('admin/register/register');
			$this->load->view('templates/footer');
		}
		else{
			$firstName = set_value('first');
            $middleName = set_value('middle');
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
            
            $userId = $this->getUserID($username);
                  
            $this->createParent($userId, $firstName, $middleName, $lastName, $email);
            
		} 
	}

	// This is the Interview/Observation form that the administrator
	// fills out for the parent.
	public function interviewObservationForm(){
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
    
    function getUserID($userName){
                
        $query = "SELECT id FROM users WHERE username ='" . $userName . "'";
        $result = mysql_query($query);
        
        return mysql_result($result,0,"id");
        
    }
    
    function datagrid($grid = 'none') {
      $columns = array(
        0 => array(
          'name' => 'Username',
          'db_name' => 'username',
          'header' => 'Username',
          'group' => 'User',
          'required' => TRUE,
          'unique' => TRUE,
          'form_control' => 'text_long',
          'type' => 'string'),
        1 => array(
          'name' => 'email',
          'db_name' => 'email',
          'header' => 'email',
          'group' => 'User',
          'required' => TRUE,
          'visible' => TRUE,
          'form_control' => 'text_short',
          'type' => 'string'),
         2 => array(
          'name' => 'HasChangedPassword',
          'db_name' => 'HasChangedPassword',
          'header' => 'HasChangedPassword',
          'group' => 'User',
          'required' => TRUE,
          'visible' => TRUE,
          'form_control' => 'text_short',
          'type' => 'string'),
         3 => array(
          'name' => 'FirstName',
          'db_name' => 'id',
          'header' => 'FirstName',
          'group' => 'User',
          'ref_table_db_name' => 'Parent',
          'ref_field_db_name' => 'FirstName',
          'ref_table_id_name' => 'UserID',
          'required' => TRUE,
          'visible' => TRUE,
          'form_control' => 'text_short',
          'type' => '1-n'),
         4 => array(
          'name' => 'LastName',
          'db_name' => 'id',
          'header' => 'LastName',
          'group' => 'User',
          'ref_table_db_name' => 'Parent',
          'ref_field_db_name' => 'LastName',
          'ref_table_id_name' => 'UserID',
          'required' => FALSE,
          'visible' => TRUE,
          'form_control' => 'text_short',
          'type' => '1-n'),
      );
      
      $params = array(
                'id' => 'users',
                'table' => 'users',
                'url' => 'admin/datagrid',
                'uri_param' => $grid,
                'columns' => $columns,
                
                'ajax' => TRUE
            );
     
            $this->load->library('carbogrid', $params);
     
            if ($this->carbogrid->is_ajax)
            {
                $this->carbogrid->render();
                return FALSE;
            }
     
            // Pass grid to the view
            
            $data->page_grid = $this->carbogrid->render();
     
            //$this->load->view('templates/header', $this->data);  
            $this->load->view('admin/datagrid/datagrid', $data);
            //$this->load->view('templates/footer');
    }
    
    function addMenuItem(){
        $this->data['allMenuItems'] = Menu_item::all(array('select' => 'MenuItemID, Label')); 
		
        $this->form_validation->set_rules('menuItemID', 'menuItemID', 'required');
        $this->form_validation->set_rules('label', 'label', 'required');
        $this->form_validation->set_rules('URL', 'URL', 'required');
        $this->form_validation->set_rules('rankOrder', 'rankOrder', 'required');

        if($this->form_validation->run() == FALSE){
            $this->load->view('templates/header', $this->data);  
            $this->load->view('admin/menu/add_menu_item', $this->data);
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
}

/* End of file: dashboard.php */
/* Location: application/controllers/admin/dashboard.php */
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Application{
	
	private static $data = array();
	
	public function __construct(){
				
		parent::__construct();
		
		/* restrict access to all but admin */
		$this->ag_auth->restrict('admin');
		
		/* Load helpers */
		$this->load->helper(array('url', 'form', 'registration'));
        
		/* Load libraries */
		$this->load->library('form_validation', '');
        $this->load->library('Repositories/Registration_Repository', '', 'reg'); 
		
		/* Load Models*/
		//$this->load->model('menu_item');
        //$this->load->model('sub_item');
		
		# setup default view data
		$this->data['title'] = 'Admin Dashboard';
		
		
		
		$mItems = Menu_item::all(array('order' => 'RankOrder asc'));
		// TODO: limit menu items to admin
		$this->data['MenuItems'] = $mItems;
		
		$mItem = Menu_item::first();
		$grp = $mItem->groups;
		var_dump($grp);
		
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
        $this->form_validation->set_rules('email', 'Email Address', 'required|min_length[3]|valid_email|callback_field_exists');

		if($this->form_validation->run() == FALSE){
			$this->load->view('templates/header', $this->data);	
			$this->load->view('admin/register/register');
			$this->load->view('templates/footer');
		}
		else{
			$firstName = set_value('first');
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
				
			} // if($this->ag_auth->register($username, $password, $email) === TRUE)
			else{
				echo "Error";
			}

		} // if($this->form_validation->run() == FALSE)
		
	} // public function register()
	
	public function test(){
	    $this->load->view('templates/header', $this->data);  
        $this->load->view('admissions/forms/admissionsPage1');
        $this->load->view('templates/footer');
	}

}

/* End of file: dashboard.php */
/* Location: application/controllers/admin/dashboard.php */
<<<<<<< HEAD
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Application
{
	public function __construct()
	{
		parent::__construct();
		
		/*restrict access to all but admin*/
		$this->ag_auth->restrict('admin');
		
		/* Load helpers */
		$this->load->helper(array('url', 'form'));

		/* Load libraries */
		$this->load->library('form_validation');
	}
	
	public function index()
	{
		if(logged_in())
		{
			$data = array();
			$data['title'] = 'Admin Dashboard';
	
			/* load views */
			$this->load->view('admin/templates/header', $data);
			$this->load->view('admin/dashboard', $data);
			$this->load->view('admin/templates/footer', $data);
		}
		else
		{
			$this->login();
		}
	}
	
	public function register()
	{
		$this->form_validation->set_rules('first', 'First Name', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('last', 'Last Name', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('email', 'Email Address', 'required|min_length[3]|valid_email|callback_field_exists');

		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('admin/register/register');
		}
		else
		{
			$username = set_value('username');
			$password = $this->ag_auth->salt(set_value('password'));
			$email = set_value('email');

			if($this->ag_auth->register($username, $password, $email) === TRUE)
			{
				$data['message'] = "The user account has now been created.";
				$this->ag_auth->view('message', $data);
				
			} // if($this->ag_auth->register($username, $password, $email) === TRUE)
			else
			{
				$data['message'] = "The user account has not been created.";
				$this->ag_auth->view('message', $data);
			}

		} // if($this->form_validation->run() == FALSE)
		
	} // public function register()
}

/* End of file: dashboard.php */
=======
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Application
{
	public function __construct()
	{
		parent::__construct();
		
		/*restrict access to all but admin*/
		$this->ag_auth->restrict('admin');
		
		/* Load helpers */
		$this->load->helper(array('url', 'form', 'registration'));
        
		/* Load libraries */
		$this->load->library('form_validation', '');
        $this->load->library('Repositories/Registration_Repository', '', 'reg');
        
	}
	
	public function index()
	{
		if(logged_in())
		{
			$data = array();
			$data['title'] = 'Admin Dashboard';
	
			/* load views */
			$this->load->view('templates/header', $data);
			$this->load->view('admin/dashboard', $data);
			$this->load->view('templates/footer', $data);
		}
		else
		{
			$this->login();
		}
	}
	
	public function register()
	{
		$this->form_validation->set_rules('first', 'First Name', 'required|min_length[1]|callback_field_exists');
        $this->form_validation->set_rules('last', 'Last Name', 'required|min_length[1]|callback_field_exists');
        $this->form_validation->set_rules('email', 'Email Address', 'required|min_length[3]|valid_email|callback_field_exists');

		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('templates/header');	
			$this->load->view('admin/register/register');
			$this->load->view('templates/footer');
		}
		else
		{
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

			if($this->ag_auth->register($username, $password, $email) === TRUE)
			{
				sendNewUserAccountCreationEmail($firstName, $lastName, $email, $username, $plainTextPassword);
                
                $data['firstName'] = $firstName;
                $data['lastName'] = $lastName;
                $data['email'] = $email;
                $data['username'] = $username;
                $data['plainTextPassword'] = $plainTextPassword;
                
                $this->load->view('templates/header');  
                $this->load->view('admin/register/success' , $data);
                $this->load->view('templates/footer');
				
			} // if($this->ag_auth->register($username, $password, $email) === TRUE)
			else
			{
				echo "Error";
			}

		} // if($this->form_validation->run() == FALSE)
		
	} // public function register()

}

/* End of file: dashboard.php */
>>>>>>> f89257a2aba01cba4c82e8baae05ea367c4ca8e4
/* Location: application/controllers/admin/dashboard.php */
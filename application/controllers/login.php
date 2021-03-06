<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Login extends Application {

	private static $data = array();

	function __construct() {
		parent::__construct();
		
		/* Disable Cashcing */
		$this->output->nocache();

		# Load Helpers
		$this->load->helper(array('url', 'form', 'dashboard', 'ag_auth', 'registration', 'notification'));

		# Load Libraries
		$this->load->library('form_validation');
        
        # Load Config
        $this->config->load('ag_auth');
		
		$mItems = Menu_item::all(array('order' => 'RankOrder asc'));
		
		$this->data['MenuItems'] = $mItems;
	}

	# This is the default login view
	function index() {
		$data          = array();
		$data['title'] = 'Login';
		

		//if the user is already logged in goto their default dashboard
		if(logged_in())
		{
			if(!checkPass())
                $this->changePass();
            else
    			// redirect to the appropriate dashboard
    			redirect(get_dashboard());
		}
		else // else present them with the login page.
		{
			$this->login();
		}
	}
    
    function changePass(){
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|matches[passconf]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');   
            
        if ($this->form_validation->run() == FALSE)
            $this->load->view('login/password/change_password');     
        else{
            $plainTextPassword = set_value('password');
            $saltedPassword = $this->ag_auth->salt($plainTextPassword); 
            
            //TODO this belongs in a model
            $query = "UPDATE users SET password='". $saltedPassword . "', HasChangedPassword = 1 WHERE username = '" . username() . "'";     
            
            mysql_query($query); 
            
            redirect(get_dashboard());
        }
        
    }
	
    function forgotPass(){
            
        $this->form_validation->set_rules('username', 'username', 'required');   
            
        if ($this->form_validation->run() == FALSE)
            $this->load->view('login/password/forgot_password');     
        else{
                
            $username = set_value('username');    
             
            $plainTextPassword = generatePassword();
            $saltedPassword = $this->ag_auth->salt($plainTextPassword);
                    
            $query = "UPDATE users SET password='". $saltedPassword . "', HasChangedPassword = 0 WHERE username = '" . $username . "'";     
            mysql_query($query);
            
            $username = set_value('username');
            $info = $this->getUserinfo($username);
            
            $firstName = $info['first'];
            $lastName = $info['last'];
            $email = $info['email'];
            
            sendNewUserAccountCreationEmail($firstName, $lastName, $email, $username, $plainTextPassword);
            
            redirect(get_dashboard());
        }
    }
	
	function wrongPassword(){
		
		$this->load->view('login/password/wrong_password'); 
		
	}
    

    
}

?>

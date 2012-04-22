<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Login extends Application {

	private static $data = array();

	function __construct() {
		parent::__construct();

		# Load Helpers
		$this->load->helper(array('url', 'form', 'dashboard', 'ag_auth'));

		# Load Libraries
		$this->load->library('form_validation');
        
		# Load Modules
		$this->load->model('alerts_model');
        
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
        $this->form_validation->set_rules('password', 'Password', 'required|matches[passconf]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');   
            
        if ($this->form_validation->run() == FALSE)
            $this->load->view('login/change_password/change_password');     
        else{
            $plainTextPassword = set_value('password');
            $saltedPassword = $this->ag_auth->salt($plainTextPassword); 
            
            $query = "UPDATE users SET password='". $saltedPassword . "', HasChangedPassword = 1 WHERE username = '" . username() . "'";     
            mysql_query($query); 
            
            $this->load->view('login/change_password/success');
        }
        
    }
	
}

?>

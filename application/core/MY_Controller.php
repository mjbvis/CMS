<?php
/**
* Authentication Library
*
* @package Authentication
* @category Libraries
* @author Adam Griffiths
* @link http://adamgriffiths.co.uk
* @version 2.0.3
* @copyright Adam Griffiths 2011
*
* Auth provides a powerful, lightweight and simple interface for user authentication .
*/

class Application extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		log_message('debug', 'Application Loaded');

		# Load Libraries
		$this->load->library(array('ag_auth'));
		# Load Helpers
		$this->load->helper(array('url', 'email', 'ag_auth', 'dashboard', 'form'));
		# Load Config
		$this->config->load('ag_auth');
		# Load Modules
		$this->load->model('alerts_model');

	}
	
	public function field_exists($value)
	{
		$field_name  = (valid_email($value)  ? 'email' : 'username');
		
		$user = $this->ag_auth->get_user($value, $field_name);
		
		if(array_key_exists('id', $user))
		{
			$this->form_validation->set_message('field_exists', 'The ' . $field_name . ' provided already exists, please use another.');
			
			return FALSE;
		}
		else
		{			
			return TRUE;
			
		} // if($this->field_exists($value) === TRUE)
		
	} // public function field_exists($value)
	
	public function login($redirect = NULL)
	{
		//if the user is already loged in goto their default dashboard
		if(logged_in())
		{
			// redirect to the appropriate dashboard
			redirect(get_dashboard());
		}
			
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[1]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[1]');
		
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('login/login');
		}
		else
		{
			$username = set_value('username');
			$password = $this->ag_auth->salt(set_value('password'));
			$field_type  = (valid_email($username)  ? 'email' : 'username');
			
			$user_data = $this->ag_auth->get_user($username, $field_type);
			
			
			if(array_key_exists('password', $user_data) AND $user_data['password'] === $password)
			{
				
				unset($user_data['password']);

				$this->ag_auth->login_user($user_data);
				
				// get all alerts for current user
				$alerts = $this->alerts_model->selectUserAlerts(user_id());
				
				// put parents in the alert group if they have alerts to deal with  
            	if($this->alerts_model->userHasAlerts(user_id()) && user_group('parent') == TRUE) {
                	$alertGroupID = $this->ag_auth->config['auth_groups']['alert'];
                	$this->alerts_model->changeGroup(user_id(), $alertGroupID);
            	}

				if($redirect === NULL){
					$redirect = get_dashboard();
				}
			
				redirect($redirect);
			} 
			else
			{
				echo "error";
			}
		}
	}
	
	public function logout()
	{
		$this->ag_auth->logout();
	}
	
}

/* End of file: MY_Controller.php */
/* Location: application/core/MY_Controller.php */
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

		$this->load->library(array('form_validation', 'ag_auth'));
		$this->load->helper(array('url', 'email', 'ag_auth', 'dashboard'));
		$this->config->load('ag_auth');

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
			
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[6]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
		
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
				unset($user_data['id']);

				$this->ag_auth->login_user($user_data);
				
				if($redirect === NULL){
					$redirect = get_dashboard();
				}
				
				redirect($redirect);
				
				
			} 
			else
			{
				$data['message'] = "The username and password did not match.";
				$this->ag_auth->view('message', $data);
			}
		} // if($this->form_validation->run() == FALSE)
		
	} // login()
	
	public function logout()
	{
		$this->ag_auth->logout();
	}
	
}

/* End of file: MY_Controller.php */
/* Location: application/core/MY_Controller.php */
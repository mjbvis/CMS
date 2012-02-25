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
			$this->load->view('admin/templates/header');	
			$this->load->view('admin/register/register');
			$this->load->view('admin/templates/footer');
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
/* Location: application/controllers/admin/dashboard.php */
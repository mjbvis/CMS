<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Login extends Application {

	function __construct() {
		parent::__construct();

		# Load Helpers
		$this->load->helper(array('url', 'form', 'dashboard'));

		# Load Libraries
		$this->load->library('Repositories/Login_Repository', '', 'Repo');
		
		# Load Modules
		$this->load->model('login/Login_model');
	}

	# This is the default login view
	function index() {
		$data          = array();
		$data['title'] = 'Login';
		

		//if the user is already loged in goto their default dashboard
		if(logged_in())
		{
			// get all alerts for current user
			$alerts = $this->Repo->selectUserAlerts(user_id());
			// redirect to the appropriate dashboard
			redirect(get_dashboard($alerts));
		}
		else // else present them with the login page.
		{
			$this->login();
		}
	}
	
}

?>

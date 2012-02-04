<?php
class Login extends Application {

	function __construct() {
		parent::__construct();

		# Load Helpers
		$this->load->helper(array('url', 'form'));

		# Load Libraries

		# Load Modules

	}

	# This is the default login view
	function index() {
		$data          = array();
		$data['title'] = 'Login';
		

		//if the user is allready loged in goto there default dashboard
		if(logged_in())
		{
			$this->ag_auth->view('dashboard');
		}
		else // else present them with the login page.
		{
			$this->login();
		}
	}

}
?>

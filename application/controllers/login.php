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
		$data['title'] = 'login';
		
		# Model call here

		# Load Views
		$this->load->view('templates/header.php', $data);
		$this->load->view('login_views/login_view', $data);
		$this->load->view('templates/footer.php', $data);
	}
	
	# Performs the login process
	function login() {
		# is validate login?
		
		# is first login? If so, change password
		
		# if not, forward to the landing page
		$this->load->view('templates/header.php', $data);
		$this->load->view('landing_views/landing_view', $data);
		$this->load->view('templates/footer.php', $data);
	}

	function changePassword() {
		
	}

}
?>

<?php
class Landing extends CI_Controller {

	function __construct() {
		parent::__construct();

		# Load Helpers
		$this->load->helper(array('url', 'form'));

		# Load Libraries

		# Load Modules

	}

	function index() { # Necessary for auto index     Have this function in ALL views
		# array with example data
		$data          = array();
		$data['title'] = 'Landing';
		
		# Model call here

		# Load Views
		$this->load->view('templates/header.php', $data);
		$this->load->view('landing_views/landing_view', $data);
		$this->load->view('templates/footer.php', $data);
	}

}
?>

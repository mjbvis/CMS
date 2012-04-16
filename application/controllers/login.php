<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Login extends Application {

	private static $data = array();

	function __construct() {
		parent::__construct();

		# Load Helpers
		$this->load->helper(array('url', 'form', 'dashboard', 'ag_auth'));

		# Load Libraries
		
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
			// redirect to the appropriate dashboard
			redirect(get_dashboard());
		}
		else // else present them with the login page.
		{
			$this->login();
		}
	}
	
}

?>

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Login extends Application {

	function __construct() {
		parent::__construct();

		# Load Helpers
		$this->load->helper(array('url', 'form', 'dashboard'));

		# Load Libraries
		
		# Load Modules
		$this->load->model('alerts_model');
        
        # Load Config
        $this->config->load('ag_auth');
	}

	# This is the default login view
	function index() {
		$data          = array();
		$data['title'] = 'Login';
		

		//if the user is already loged in goto their default dashboard
		if(logged_in())
		{
			// get all alerts for current user
			$alerts = $this->alerts_model->selectUserAlerts(user_id());
            
            // put parents in the alert group if they have alerts to deal with  
            if($alerts->num_rows()>0 && user_group('parent') == TRUE) {
                //$alertGroupID = $this->ag_auth->config['auth_groups']['alert'];
                $this->alerts_model->changeGroup(user_id(), '200');
        
            }
            else{
            redirect('admin');
            }
            
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

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Alerts extends Application
{
	public function __construct()
	{
		parent::__construct();
		
		/*restrict access to all but admin*/
		//$this->ag_auth->restrict('alert');
		
		/* Load helpers */
		$this->load->helper(array('url', 'form'));

		/* Load libraries */
		$this->load->library('form_validation');
        
        # Load Libraries
        $this->load->library('Repositories/Login_Repository', '', 'alert');
        
	}
	
	public function index()
	{
		if(logged_in())
		{
			$data = array();
			$data['title'] = 'Alert Dashboard';
	
            // get all alerts for current user
            $data['alerts'] = $this->Repo->selectUserAlerts(user_id());
    
			/* load views */
			$this->load->view('templates/header', $data);
			$this->load->view('alerts/dashboard', $data);
			$this->load->view('templates/footer', $data);
		}
		else
		{
			$this->login();
		}
	}

}

/* End of file: dashboard.php */
/* Location: application/controllers/admin/dashboard.php */
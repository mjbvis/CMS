<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Alerts extends Application
{
	private static $data = array();
	
	public function __construct()
	{
		parent::__construct();
		
		/*restrict access to all but admin*/
		//$this->ag_auth->restrict('alert');
		
		/* Load helpers */
		$this->load->helper(array('url', 'form', 'menu', 'alerts'));
    	/* Load libraries */

        /* Load Models */
        $this->load->model('alerts_model');
		
		# setup default view data
		$this->data['title'] = 'Alert Dashboard';
		$this->data['MenuItems'] = get_menu_items('alert');
		$this->data['userAlerts'] = selectUserAlerts(user_id());
	}
	
	public function index()
	{
		if(logged_in())
		{
			/* load views */
			$this->load->view('templates/header', $this->data);
			$this->load->view('alerts/dashboard', $this->data);
			$this->load->view('templates/footer');
		}
		else
		{
			$this->login();
		}
	}

}

/* End of file: dashboard.php */
/* Location: application/controllers/admin/dashboard.php */
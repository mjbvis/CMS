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
		$this->load->helper(array('url', 'form'));
    	/* Load libraries */
		$this->load->library('form_validation');
        /* Load Models */
        $this->load->model('alerts_model');
		
		$mItems = Menu_item::all(array('order' => 'RankOrder asc'));
		// TODO: limit menu items to admin
		$this->data['MenuItems'] = $mItems;
	}
	
	public function index()
	{
		if(logged_in())
		{
			$data = array();
			$data['title'] = 'Alert Dashboard';

			$mItems = Menu_item::all(array('order' => 'RankOrder asc'));
			// TODO: limit menu items to admin
			$data['MenuItems'] = $mItems;

            $data['userAlerts'] = $this->alerts_model->selectUserAlerts(user_id());
  
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
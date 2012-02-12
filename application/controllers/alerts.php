<?php

class Alerts extends Application
{
	public function __construct()
	{
		parent::__construct();
		
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
			$data['title'] = 'Alert Dashboard';
	
			/* load views */
			$this->load->view('alerts/templates/header', $data);
			$this->load->view('alerts/dashboard', $data);
			$this->load->view('alerts/templates/footer', $data);
		}
		else
		{
			$this->login();
		}
	}

}

/* End of file: dashboard.php */
/* Location: application/controllers/admin/dashboard.php */
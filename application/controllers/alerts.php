<<<<<<< HEAD
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
=======
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
	}
	
	public function index()
	{
		if(logged_in())
		{
			$data = array();
			$data['title'] = 'Alert Dashboard';
	
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
>>>>>>> f89257a2aba01cba4c82e8baae05ea367c4ca8e4
/* Location: application/controllers/admin/dashboard.php */
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Parents extends Application {

	private static $data = array();

	function __construct() {
		parent::__construct();

		/*restrict access to all but parents*/
		$this->ag_auth->restrict('parent');

		/* Load helpers */
		$this->load->helper(array('url', 'form'));

		/* Load libraries */
		$this->load->library('form_validation');

		$mItems = Menu_item::all(array('order' => 'RankOrder asc'));
		// TODO: limit menu items to admin
		$this->data['MenuItems'] = $mItems;
	}

	function index() {
		
		if(logged_in())
		{
			/* array with example data */
			$this->data = array();
			$this->data['title'] = 'Page Title';

			$mItems = Menu_item::all(array('order' => 'RankOrder asc'));
			// TODO: limit menu items to admin
			$this->data['MenuItems'] = $mItems;
	
			/* load views */
			$this->load->view('templates/header', $this->data);
			$this->load->view('parents/dashboard', $this->data);
			$this->load->view('templates/footer');
		}
		else {
			$this->login();
		}
		
	}

}
?>
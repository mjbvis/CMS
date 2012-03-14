<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

Class Parents extends Application {

	function __construct() {
		parent::__construct();

		/*restrict access to all but parents*/
		$this->ag_auth->restrict('parent');

		/* Load helpers */
		$this->load->helper(array('url', 'form'));

		/* Load libraries */
		$this->load->library('form_validation');


	}

	function index() {
		
		if(logged_in())
		{
			/* array with example data */
			$data = array();
			$data['title'] = 'Page Title';

			$mItems = Menu_item::all(array('order' => 'RankOrder asc'));
			// TODO: limit menu items to admin
			$data['MenuItems'] = $mItems;
	
			/* load views */
			$this->load->view('templates/header', $data);
			$this->load->view('parents/dashboard', $data);
			$this->load->view('templates/footer', $data);
		}
		else {
			$this->login();
		}
		
	}

}
?>
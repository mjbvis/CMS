<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class BoilerPlate extends Application {

	function __construct() {
		parent::__construct();

		/* Load helpers */
		$this->load->helper(array('url', 'form'));

		/* Load libraries */
		$this->load->library('form_validation');

		/* Load models */
		$this->load->model('BoilerPlate_model', 'model_codename');
	}

	function index() {
		/* array with example data */
		$data = array();
		$data['title'] = 'Page Title';

		/* example model function call */
		$data['query'] = $this->model_codename->get_users();

		/* load views */
		$this->load->view('templates/header', $data);
		$this->load->view('templates/boilerPlate_view', $data);
		$this->load->view('templates/footer', $data);
	}

}
?>
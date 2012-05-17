<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Test extends Application{
	
	private static $data = array();
	
	public function __construct(){
				
		parent::__construct();
		
		/* restrict access to all but admin */
		$this->ag_auth->restrict('admin');
		
		// load database
		$this->load->database();
		
		/* Load helpers */
		$this->load->helper(array('url', 'form', 'registration', 'menu', 'language'));
        
		/* Load libraries */
        	$this->load->library('grocery_CRUD');
		
		/* setup default view data */
		$this->data['title'] = 'Admin Dashboard';
		$this->data['MenuItems'] = get_menu_items('admin');
	}
	
	public function index(){
				
		if(logged_in()){
		
	
		//* load views */
		$this->load->view('templates/header', $this->data);		
		$this->load->view('test/dashboard');
		$this->load->view('templates/footer');

		}
		else{
			$this->login();
		}
	}

	function grid1(){
	
		$this->grocery_crud->set_table('WaitlistForm');
        	$output = $this->grocery_crud->render();
		$this->load->view('test/grid',$output);
	
	}

	function grid2(){
	
		$this->grocery_crud->set_table('users');
        	$output = $this->grocery_crud->render();
		$this->load->view('test/grid',$output);
	
	}
	
}

/* End of file: dashboard.php */
/* Location: application/controllers/admin/dashboard.php */

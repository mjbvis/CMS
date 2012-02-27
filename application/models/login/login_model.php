<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
/* This file will hold all database queries for the student Table */
class Login_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();
		
		// load repository
		$this->load->library('Repositories/Login_Repository', '', 'Repo');
	}
}
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
/* This file will hold all database queries for the student Table */
class AdmissionsModel extends CI_Model{
	
	public function __construct(){
		parent::__construct();
		
		// load repository
		$this->load->library('Repositories/Admissions_Repository', '', 'Repo');
	}
	
	function savePageOne($data) {
		return $this->Repo->insertPageOne($data);
	}
	
	function savePageTwo($data) {
		return $this->Repo->insertPageTwo($data);
	}
	
	function savePageThree($data) {
		return $this->Repo->insertPageThree($data);
	}
	
	function savePageFour($data) {
		return $this->Repo->insertPageFour($data);
	}
	
	function savePageFive($data) {
		return $this->Repo->insertPageFive($data);
	}
}
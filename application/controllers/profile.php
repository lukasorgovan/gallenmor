<?php

class Profile extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
	}
	public function characters() {
		if ($this->session->userdata('username')) {
			$this->load->view('pages/registerSimple', $data);
		}
		else if ($this->session->userdata('user')) {
			echo "Vitaj uzivatel";
			echo "Load all information from database, populate javascript framework, Behave as single app.";
			
		}
		else {
			redirect(base_url() . 'login', 'location');
		}
	}
}
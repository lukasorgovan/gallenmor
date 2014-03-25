<?php

class Profile extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
	}
	public function characters() {
		if ($this->session->userdata('username')) {
			echo '<h1>Hidden section: debug data info</h1>
			<pre>';
			print_r($this->session->all_userdata());
			echo '</pre>';
		}
	}
}
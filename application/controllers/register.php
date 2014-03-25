<?php

class Register extends CI_Controller
{

	public function index()
	{
		$this->load->view('pages/register');
	}
	public function simple() {
		$this->load->library('session');
		if ($this->session->userdata('logged') == TRUE && $this->session->userdata('username')) {
			$data = array (
				'username' => $username = $this->session->userdata('username')
			);
		}
		else { $data = array(); }
		$this->load->view('pages/registerSimple', $data);
	}
	public function advanced() {
		$this->load->view('pages/registerAdvanced');
	}
}
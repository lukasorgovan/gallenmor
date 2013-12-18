<?php

class Register extends CI_Controller
{
	public function index()
	{
		$this->load->view('pages/register');
	}
	public function simple() {
		$this->load->view('pages/registerSimple');
	}
	public function advanced() {
		$this->load->view('pages/registerAdvanced');
	}
}
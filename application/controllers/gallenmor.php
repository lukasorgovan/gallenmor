<?php

class Gallenmor extends CI_Controller
{
	public function index($page = 'home')
	{
		$this->load->view('pages/generator');
	}
}
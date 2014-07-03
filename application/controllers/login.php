<?php

class Login extends CI_Controller
{

	public function index()
	{
		$this->load->model('api_model');
		$this->load->helper('url');

		$login = $this->input->post('login');
		$password = $this->input->post('password');
		
		echo $login . $password;
		
		if ($login != FALSE && preg_match("/^[0-9a-z]{6,}$/i", $password)) {
			$userLoggedIn = $this->api_model->login($login, $password);
			if ($userLoggedIn) {
				
				redirect(base_url() . 'profile/characters', 'location');
			}
			else {
				$data['error'] = 'login';
				$this->load->view('pages/login', $data);
			}
		}
		else {
			$data['error'] = 'tu je chyba';
			$this->load->view('pages/login', $data);
		}
	}
}
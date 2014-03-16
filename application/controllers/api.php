<?php

class Api extends CI_Controller {
	private $method = null;

	public function __construct() {
		parent::__construct();
		$this->load->model('Api_model');
		$this->output->set_header('Content-Type: application/json; charset=utf-8');
		$this->method = $this->_detect_method();
	}

	public function index($page = 'home') {
		echo 'This is help file for Gallenmor simple API';
	}
	/**
	 * Name Generator
	 *
	 * RESTful: Used for create and retrieve names in name generator
	 *
	 * @param string $race selected race
	 * @param integer $limit how many names should be fetched
	 * @return JSON data on GET
	 */
	public function generator($race = 'severania', $limit = 5) {
		switch ($this->method) {
			case 'post':
				$data = $this->input->post(NULL, TRUE);
				$response = $this->Api_model->generator_post($data['race'], $data['name']);
				echo json_encode($response);

				break;
			case 'get':
				// GET Request behaviour
				$names = $this->Api_model->generator_get($race, $limit);
				if ($names) {
					echo json_encode($names);
				}
				else {
					echo 'We did not find any names in our database yet.';
				}
				break;
				
			default:
				show_404();
		}
	}
	/**
	 * Checks if user name is availible in system or already taken.
	 * @return boolean true/false
	 */
	public function checkUserNameAvailibility() {
		$data = $this->input->post(NULL, TRUE);
		$response = $this->Api_model->checkUserNameAvailibility($data['username']);
		echo $response;
	}

	public function races() {

		switch ($this->method) {
			case 'get': 
			
				$races = $this->Api_model->races_get();
				if ($races) {
					echo json_encode($races);
				}
				else {
					echo 'We did not find any races in our database yet.';
				}
				break;

			default:
				show_404();
		}
	}
 
	 /**
	 * Detect method
	 *
	 * Detect which method (POST, PUT, GET, DELETE) is being used
	 * 
	 * @return string 
	 */
	protected function _detect_method() {
	  $method = strtolower($this->input->server('REQUEST_METHOD'));

	  if ($this->config->item('enable_emulate_request')) {
	    if ($this->input->post('_method')) {
	      $method = strtolower($this->input->post('_method'));
	    } else if ($this->input->server('HTTP_X_HTTP_METHOD_OVERRIDE')) {
	      $method = strtolower($this->input->server('HTTP_X_HTTP_METHOD_OVERRIDE'));
	    }      
	  }

	  if (in_array($method, array('get', 'delete', 'post', 'put'))) {
	    return $method;
	  }

	  return 'get';
	}
}
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
	public function checkAvailibility($table, $entity) {
		if ($entity == 'username' || $entity == 'name' || $entity == 'email') {
			$data = $this->input->post(NULL, TRUE);
			$response = $this->Api_model->checkAvailibility($data[$entity],  $table, $entity);
		} 
		else {
			$response = 0;
		}
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
 	public function register() {
 		switch ($this->method) {
			case 'post': 
			  $error_messages = array();
				$data = $this->input->post();
				// If no data were recieved, nothing to do.
				if (! $data) {
					$error_messages[] = 'service_failed';
					echo json_encode($error_messages);
				}
				else {
					foreach ($data as $key => $value) {

						switch ($key) {

							case 'username':
								if (preg_match("/^[a-zľščťžýáíéúäňôö]{2,}[0-9]{0,2}$/i", $value)) {
									$res = $this->Api_model->checkAvailibility($value, 'users', $key);
									

									if ($res != '0') {
										$error_messages[] = 'username_taken';	
									}
								}
								else { $error_messages[] = $key; }
								break;
							case 'email':
								if (preg_match("/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/", $value)) {
									if ($this->Api_model->checkAvailibility($value, 'users', $key) != 0) {
										$error_messages[] = 'email_taken';	
									}
								}
								else { $error_messages[] = $key; }
								break;
							case 'charname':
								if (preg_match("/^([a-zľščťžýáíéúäňôö']{2,} '?[a-zľščťžýáåäíéúňôö']{2,}( ?'?[a-zľščťžýäáäíéúňôö']{2,})?)$/i", $value)) {
									if ($this->Api_model->checkAvailibility($value, 'characters', $key) != 0) {
										$error_messages[] = 'charname_taken';	
									}
								}
								else { $error_messages[] = $key; }
								break;
							case 'date':
								if (! preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $value)) {
									$error_messages[] = $key;
								}
								break;
							case 'password':
								if (! preg_match("/^[0-9a-z]{6,}$/i", $value)) {
									$error_messages[] = $key;
								}
								break;
							case 'password-check':
								if ($value != $data['password']) {
									$error_messages[] = $key;
								}
								break;
							case 'age':
								if (! preg_match("/^[0-9]{1,4}$/", $value)) {
									$error_messages[] = $key;
								}
								break;
						}
					}
					// When no error message yet, try to make db transaction to register user
					if (count($error_messages) == 0) {
						// If transaction was unsucessfull, add error
						/*if (! $this->Api_model->registerUserChar($data)) {
							$error_messages[] = 'service_failed';
							echo json_encode($error_messages);
						}
						
						// Everything is OK, let's party
						else {*/
							echo 'true';
						//}
					}
					else {
						echo json_encode($error_messages);
					}
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
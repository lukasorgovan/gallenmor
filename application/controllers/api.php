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
			
				echo '
				{
					"svetli-elfovia": {
						"name": "Svetli elfovia",
						"desc": "Odievajú sa do drahých látok, ich šatstvo je vo všeobecnosti považované za špičku Gallenmorského odevníctva. Nosia mnoho šperkov - od náhrdelníkov a amuletov s drahokamami, či portrétmi, cez spony a čelenky zo zlata a striebra, až po prstene zdobené mesačnými kameňmi."
					},
					"juzania": {
						"name": "Juzania",
						"desc": "Hoci mnohí Južania ručne vyrábajú prekrásne šperky, tak nie sú významnou súčasťou ich vonkajšieho vzhľadu. Bežnými sú len náramky, nákrčníky a nánožníky. Hlavnými materiálmi pri výrobe šperkov sú pre nich kovy ako zlato a meď, ďalším z materiálov je drevo a spomedzi kameňov preferujú jantár a mesačné kamene."
					},
					"severania": {
						"name": "Severania",
						"desc": "Ženský odev sa skladá z jednoduchých šiat rôznych farieb s dlhými rukávmi a so šnurovaním na hrudi. Počas zimy ženy Severanky nosia obdobu týchto šiat podšitú spodnicami a podobne ako muži sa i ony chránia pred chladom plášťom a kožušinou."
					},
					"cigani": {
						"name": "Cigani",
						"desc": "Krása či bohatstvo sa u cigánov meria aj šperkmi, ktoré nosia. Rešpekt a váženosť v komunite totiž býva priamoúmerná množstvu šperkov, ktoré cigán vlastní. Ich retiazky alebo náhrdelníky, tiež náušnice, náramky a prstienky bývajú väčšinou zo zlata, či iných, zlato obsahujúcich kovov. Na tradičnejších šperkoch nechýbajú ani drevené koráliky, pestrofarebné pierka alebo kosti drobných zvierat."
					},
					"temni-elfovia": {
						"name": "Temni elfovia",
						"desc": "Prvoradým účelom temnoelfskej garderóby je praktickosť, i preto je veľa šperkov, ktoré nosia jednoduchých, ba priam až stroho primitívnych. Väčšina z nich má pre nich náboženský význam a zdobené bývajú mesačnými kameňmi, ktoré považujú za dar nočnej oblohy a ich plýtvanie, či zneužívanie kvôli magickej sile za rúhanie a zradu kultu Noci a rovnako za výsmech ich rase. Spomedzi kovov preferujú striebro a typickými symbolmi sú pre nich polmesiac a štvorcípa hviezda."
					}
				}'; 
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
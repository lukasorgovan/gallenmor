<?php

class Clubhouses extends CI_Controller {

    public function index() {
        $this->load->view('clubhouses/index');
    }

    public function race($race) {
        $data['race'] = $race;
        $this->load->view('clubhouses/race', $data);
    }

    public function sendMessage() {
        
    }

}

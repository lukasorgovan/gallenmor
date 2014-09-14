<?php

class loggedController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('login_state') != TRUE) {
            redirect(site_url('login'));
        }
    }

}

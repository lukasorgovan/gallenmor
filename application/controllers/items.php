<?php

class Items extends LoggedController {

    public function __construct() {
        parent::__construct();
        $this->load->model('item');
    }

    /**
     * Display Shop home page
     */
    public function index() {
        $this->load->view('items/index');
    }

    

}

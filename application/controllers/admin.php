<?php

class Admin extends LoggedController {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin_tools');
    }

    /**
     * Default index action. 
     * List of all administration tools.
     */
    public function index() {
        if ($this->session->userdata('authority') != 99) {
            redirect('profile/characters'); // redirect if not admin
        }
        $this->load->view('admin/index');
    }

}

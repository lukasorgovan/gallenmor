<?php

class Profile extends LoggedController {

    public function index() {
        $this->load->view('profile/view');
    }

    public function edit() {
        $this->load->view('profile/edit');
    }

}

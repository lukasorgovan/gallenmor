<?php

class Login extends CI_Controller {

    public function index() {
        $this->load->view('pages/login');
    }

    public function submitLogin() {
        $this->load->model('User');

        $login = $this->input->post('login');
        $password = $this->input->post('password');

        if ($login != FALSE && preg_match("/^[0-9a-z]{6,}$/i", $password)) {
            // try to login the user
            $userLoggedIn = $this->User->login($login, $password);

            if ($userLoggedIn) {
                redirect(base_url('profile/characters'), 'location');
            } else {
                $data['error'] = 'login';
                $this->load->view('pages/login', $data);
            }
        } else {
            $data['error'] = 'tu je chyba';
            $this->load->view('pages/login', $data);
        }
    }

    /**
     * Logout current user
     */
    public function logout() {
        $this->session->set_userdata(array("login_state" => FALSE));
        $this->session->sess_destroy();
        redirect(base_url());
    }

}

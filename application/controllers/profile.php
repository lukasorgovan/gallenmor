<?php

class Profile extends LoggedController {

    public function __construct() {
        parent::__construct();
        $this->load->model('User');
    }

    public function index($id) {
        echo "Showing character's profile with id $id";
    }

    /**
     * Landing page after user is logged in. 
     * 
     * Servers as playable character selection and provides user with access to 
     * character administration (create, delete, etc.)
     */
    public function characters() {
        $data['characters'] = $this->User->getUsersCharacters($this->session->userdata('id'));

        $this->load->view('profile/view', $data);
    }

    public function edit() {
        if ($this->input->post('edit_accout') == 1) {

            $new_email = $this->input->post('email');

            // if user wants to update his email
            if ($new_email != $this->session->userdata('email')) {
                if ($this->User->checkAvailibility($new_email, 'users', 'email') != 0) {
                    $this->session->set_flashdata('error', 'Email sa už používa');
                }
            }


            $salt = ''; // if we are not going to update password, salt is still needed as parameter
            // if user want to update his password
            if ($this->input->post('old_password') != '') {

                // check if current password is correct
                $user_data = $this->User->getUserData($this->session->userdata('id'));
                $pass = $user_data->password;
                $salt = $user_data->salt;
                $old_pass_hash = sha1($salt . $this->input->post('old_password') . $salt);

                // check if old password is correct
                if ($old_pass_hash != $pass) {
                    $this->session->set_flashdata('error', 'Staré heslo je nesprávne');
                }

                // check if passwords match
                if ($this->input->post('new_password') != $this->input->post('new_password_copy')) {
                    $this->session->set_flashdata('error', 'Nové heslá sa nezhodudujú');
                }
            }

            // continue only if there were no errors
            if (!$this->session->flashdata('error')) {
                if ($this->User->updateAccountSetting(
                                $this->session->userdata('id'), $new_email, $this->input->post('new_password'), $salt
                        )) {
                    $this->session->set_flashdata('success', 'Nastavenia boli aktualizované.');

                    // update session email address
                    $this->session->set_userdata(array(
                        "email" => $new_email,
                    ));
                } else {
                    $this->session->set_flashdata('error', 'Nastavenia sa nepodarilo aktualizovať. Skúste to neskôr.');
                }
            }

            redirect('profile/edit'); // prevent resubmiting the form
        }

        $this->load->view('profile/edit');
    }

    function setCharacter($id) {
        // To-Do: Set session character values
    }

}

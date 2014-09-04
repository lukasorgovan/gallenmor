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

        // get validation library
        $this->load->helper('form');
        $this->load->library('form_validation');

        // user wants to edit his account
        if ($this->input->post('edit_accout') == 1) {

            // prepare variables
            $email = trim($this->input->post('email'));
            $new_password = trim($this->input->post('new_password'));
            $new_password_copy = trim($this->input->post('new_password_copy'));

            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|callback__checkEmailAvailibility');
            $this->form_validation->set_rules('old_password', 'Staré heslo', 'trim|min_length[6]|callback__passwordCheck[' . $new_password . ', ' . $new_password_copy . ']');
            $this->form_validation->set_rules('new_password', 'Nové heslo', 'trim|min_length[6]|matches[new_password_copy]');
            $this->form_validation->set_rules('new_password_copy', 'Potvrdenie nového hesla', 'trim|min_length[6]');

            if ($this->form_validation->run() == TRUE) {
                // custom validations Argh....
                if ($this->User->updateAccountSetting($this->session->userdata('id'), $email, $new_password)) {
                    $this->session->set_flashdata('success', 'Nastavenia boli aktualizované.');

                    // update session email address
                    $this->session->set_userdata(array(
                        "email" => $email,
                    ));
                    $this->session->set_flashdata('success', 'Nastavenia boli aktualizované.');
                    redirect('profile/edit'); // prevent resubmiting the form
                } else {
                    $this->form_validation->set_message('email', 'Nastavenia sa nepodarilo aktualizovať. Skúste to neskôr.');
                }
            }
        }
        $this->load->view('profile/edit');
    }

    /**
     * Custom form validation method. Check for unique email. 
     * Not accessible through URL
     * 
     * @param type $email email to be checked
     * @return boolean
     */
    public function _checkEmailAvailibility($email) {
        if ($email != $this->session->userdata('email')) {
            if ($this->User->checkAvailibility($email, 'users', 'email') != 0) {
                $this->form_validation->set_message('_checkEmailAvailibility', 'Email sa už používa');
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * Custom form validation method. Handles password validation
     * Not accessible through URL
     * 
     * @param type $password
     * @param type $params
     * @return boolean
     */
    public function _passwordCheck($password, $params) {
        $arr = explode(', ', $params);
        $new_password = $arr[0];
        $new_password_copy = $arr[1];

        if (($new_password != '' || $new_password_copy != '') && $password == '') {
            $this->form_validation->set_message('_passwordCheck', 'Nezadal si staré heslo');
            return FALSE;
        }
        if ($password != '' && $new_password != '' && $new_password_copy != '') {
            // get user's salt
            $user_data = $this->User->getUserData($this->session->userdata('id'));
            $pass = $user_data->password;
            $salt = $user_data->salt;
            $old_pass_hash = sha1($salt . $password . $salt);

            // check if old password is correct
            if ($old_pass_hash != $pass) {
                $this->form_validation->set_message('_passwordCheck', 'Staré heslo je nesprávne');
                return FALSE;
            }
        }
        return TRUE;
    }

    function setCharacter($id) {
        // To-Do: Set session character values
    }

}

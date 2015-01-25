<?php

class Profile extends LoggedController {

    public function __construct() {
        parent::__construct();
        $this->load->model('User');
        $this->load->model('Character');
    }

    public function index($id) {
        // To-Do: if id is not set display current characters profile
        echo "Showing character's profile with id $id";
        $this->output->cache(10);
    }

    /**
     * Landing page after user is logged in. 
     * 
     * Servers as playable character selection and provides user with access to 
     * character administration (create, delete, etc.)
     */
    public function characters() {
        $data['characters'] = $this->Character->get_users_characters($this->session->userdata('id'));

        $this->load->view('profile/view', $data);
    }

    /**
     * Edits account settings
     */
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

            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|callback__is_email_available');
            $this->form_validation->set_rules('old_password', 'Staré heslo', 'trim|min_length[6]|callback__passwordCheck[' . $new_password . ', ' . $new_password_copy . ']');
            $this->form_validation->set_rules('new_password', 'Nové heslo', 'trim|min_length[6]|matches[new_password_copy]');
            $this->form_validation->set_rules('new_password_copy', 'Potvrdenie nového hesla', 'trim|min_length[6]');

            if ($this->form_validation->run() == TRUE) {
                // custom validations Argh....
                if ($this->User->update_account_settings($this->session->userdata('id'), $email, $new_password)) {
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
    public function _is_email_available($email) {
        if ($email != $this->session->userdata('email')) {
            if ($this->User->check_availibility($email, 'users', 'email') != 0) {
                $this->form_validation->set_message('_is_email_available', 'Email sa už používa');
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * Displays form to manage characters on account
     */
    public function edit_characters($id = 0) {
        if ($id == 0) {
            $id = $this->session->userdata('id');
        }

        $data['admin'] = $this->session->userdata('authority') == 99;
        $data['own_account'] = $this->session->userdata('id') == $id;
        $data['account_id'] = $id;
        $data['characters'] = $this->Character->get_users_characters($id);

        $this->load->view('profile/edit_characters', $data);
    }

    /**
     * Deletes character from database
     */
    public function del_character() {
        /* To-Do: Delete only if user has more than one character */
        /* To-Do: Test if it's user's character */

        $id = (int) trim($this->input->post('delete_character'));
        $account_id = trim($this->input->post('account_id'));

        if ($this->Character->delete($id)) {
            $this->session->set_flashdata('success', 'Postava bola zmazaná.');
        } else {
            $this->session->set_flashdata('error', 'Postavu sa nepodarilo zmazať. Skúste to opäť neskôr.');
        }
        redirect('profile/edit_characters/' . $account_id); // prevent resubmiting the form
    }

    /**
     * Creates nwe character in database
     */
    public function add_character() {
        /* To-Do: Test if it's user's character */

        $race = trim($this->input->post('email'));
        $charname = trim($this->input->post('charname'));
        $gender = trim($this->input->post('gender'));
        $age = trim($this->input->post('email'));
        $account_id = trim($this->input->post('account_id'));

        if ($this->Character->create($account_id, $race, $charname, $gender, $age)) {
            $this->session->set_flashdata('success', 'Postava bola vytvorená.');
        } else {
            $this->session->set_flashdata('error', 'Postavu sa nepodarilo vytvoriť. Skúste to opäť neskôr.');
        }
        redirect('profile/edit_characters/' . $account_id); // prevent resubmiting the form
    }

    function set_character($id) {
        // To-Do: Set session character values
    }

    /**
     * Custom form validation method. Handles password validation
     * Not accessible through URL
     * 
     * @param type $password
     * @param type $params
     * @return boolean
     */
    public function _password_check($password, $params) {
        $arr = explode(', ', $params);
        $new_password = $arr[0];
        $new_password_copy = $arr[1];

        if (($new_password != '' || $new_password_copy != '') && $password == '') {
            $this->form_validation->set_message('_passwordCheck', 'Nezadal si staré heslo');
            return FALSE;
        }
        if ($password != '' && $new_password != '' && $new_password_copy != '') {
            // get user's salt
            $user_data = $this->user->get_user_data($this->session->userdata('id'));
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

}

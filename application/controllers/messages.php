<?php

class messages extends LoggedController {

    public function __construct() {
        parent::__construct();
        $this->load->model('message');
    }

    /**
     * Display inbox as default
     */
    public function index() {
        redirect('messages/inbox');
    }

    /**
     * Displays received messages for the user
     */
    public function inbox() {
        $data['messages'] = $this->message->get_received_messages($this->session->userdata('id'));
        $this->load->view('messages/inbox', $data);
    }

    /**
     * Displays incoming messages for the user
     */
    public function create() {
        $this->load->model('User');
        $data['users'] = $this->User->getAllUsers(true);


        $this->load->view('messages/new_message', $data);
    }

    /**
     * Creates new message
     */
    public function send() {
        $message = trim($this->input->post('message'));
        $to_user = trim($this->input->post('user'));

        if ($message == "" || !$message) {
            $this->session->set_flashdata('error', 'Nevyplnili ste obsah správy.');
        } else {
            if ($this->message->send($this->session->userdata('id'), $to_user, $message)) {
                $this->session->set_flashdata('success', 'Správa bola odoslaná.');
            } else {
                $this->session->set_flashdata('message', $message); // save the message
                $this->session->set_flashdata('error', 'Správu sa nepodarilo odoslať. Skúste to opäť neskôr.');
            }
        }

        // test if the message was sent from conversation view or from new message
        // view and redirect appropriately
        if ($this->input->post('conv_id') && $this->input->post('conv_id') != 0) {
            redirect('messages/conversation/' . $this->input->post('conv_id'));
        } else {
            redirect('messages/create');
        }
    }

    /**
     * 
     * @param int $id Id of the conversation
     */
    public function conversation($id) {
        $info = $this->message->get_conversation_info($id);
       

        if (count($info) == 0) {
            $data['error'] = 'Zadaná konverzácia neexistuje.';
        } else {

            // user didn't sent the mesage neither received it
            if ($info->from_user_id != $this->session->userdata('id') && $info->to_user_id != $this->session->userdata('id')) {
                $data['error'] = 'Táto konverzácia nie je určená pre teba.';
            }

            if ($info->from_user_id != $this->session->userdata('id')) {
                $data['user_id'] = $info->from_user_id;
                $data['username'] = $info->u1username;
            } else {
                $data['user_id'] = $info->to_user_id;
                $data['username'] = $info->u2username;
            }

            $data['messages'] = $this->message->get_messages($info->from_user_id, $info->to_user_id);
        }

        $this->load->view('messages/conversation', $data);
    }

}

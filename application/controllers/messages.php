<?php

class Messages extends LoggedController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Message');
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
        $data['messages'] = $this->Message->get_received_messages($this->session->userdata('id'));
        $this->load->view('messages/inbox', $data);
    }

    /**
     * Displays incoming messages for the user
     */
    public function create() {
        $this->load->model('User');

        // To-Do: Find out if bird is free
        $bird_available = $this->Message->get_bird_availability();
        $data['bird_available'] = $bird_available;
        $data['curtime'] = time();

        // To-Do: Eh, this feature is already in admin-stuff branch under Admin_tools model
        $data['users'] = $this->User->get_all_users(true);

        $this->load->view('messages/new_message', $data);
    }

    /**
     * Creates new message
     */
    public function send() {
        $message = trim($this->input->post('message'));
        $to_user = trim($this->input->post('user'));
        $send_type = trim($this->input->post('send_type'));

        // test if user has enough parchment etc.
        if (!$this->Message->check_message_supplies()) {
            
        } else {
            // check if user has enough food or gold to send message
            if (!$this->Message->send_type($send_type)) {
                if ($send_type == 'bird') {
                    $this->session->set_flashdata('error', 'Správu sa nepodarilo odoslať, pretože nemáte dostatok krmiva pre vtáka.');
                } else {
                    
                }
            } else {
                // To-Do: Calculate delivery time
                $delivered = time() + 60;

                // message can be send
                if ($message == "" || !$message) {
                    $this->session->set_flashdata('error', 'Nevyplnili ste obsah správy.');
                } else {
                    if ($this->Message->send($this->session->userdata('id'), $to_user, $message, $delivered)) {
                        $this->session->set_flashdata('success', 'Správa bola odoslaná.');
                    } else {
                        $this->session->set_flashdata('message', $message); // save the message
                        $this->session->set_flashdata('error', 'Správu sa nepodarilo odoslať. Skúste to opäť neskôr.');
                    }
                }
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
        $info = $this->Message->get_conversation_info($id);

        // To-Do: Find out if bird is free
        $bird_available = $this->Message->get_bird_availability();
        $data['bird_available'] = $bird_available;
        $data['curtime'] = time();


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

            $data['messages'] = $this->Message->get_messages($info->from_user_id, $info->to_user_id);
        }

        $this->load->view('messages/conversation', $data);
    }

}

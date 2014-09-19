<?php

class Clubhouses extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ClubhousePost');
    }

    /**
     * Default index action. 
     * Displays static text with links to all race clubhouses
     */
    public function index() {
        $this->load->view('clubhouses/index');
    }

    /**
     * Displays specified clubhouse
     * 
     * @param string $race
     */
    public function race($race) {
        $data['race'] = $race;

        // get clubhouse posts
        $data['messages'] = $this->ClubhousePost->getClubhousePosts($race);

        $this->load->view('clubhouses/race', $data);
    }

    /**
     * Adds new post to a clubhouse
     */
    public function sendMessage() {
        $message = trim($this->input->post('message'));
        $place = trim($this->input->post('place'));

        if (!$message || $message == '') {
            $this->session->set_flashdata('error', 'Nezadal si obsah správy.');
        } else {
            if ($this->ClubhousePost->createPost($message, $place)) {
                $this->session->set_flashdata('success', 'Príspevok bol pridaný.');
            } else {
                $this->session->set_flashdata('error', 'Príspevok sa nepodarilo pridať. Skúste to neskôr.');
            }
        }

        redirect('profile/race/' . $place); // redirect to the clubhouse
    }

    /**
     * Deletes a post from a clubhouse
     */
    public function deleteMessage() {
        $id = trim($this->input->post('id'));
        $place = trim($this->input->post('place'));

        if (!$id || $id == '') {
            $this->session->set_flashdata('error', 'Id príspevku nebolo zadané.');
        } else {
            if ($this->ClubhousePost->deletePost($id)) {
                $this->session->set_flashdata('success', 'Príspevok bol zmazaný.');
            } else {
                $this->session->set_flashdata('error', 'Príspevok sa nepodarilo zmazať. Skúste to neskôr.');
            }
        }

        redirect('profile/race/' . $place); // redirect to the clubhouse
    }

    /**
     * Updates a post in a clubhouse
     */
    public function updateMessage() {
        $message = trim($this->input->post('message'));
        $id = trim($this->input->post('id'));
        $place = trim($this->input->post('id'));

        if (!$message || $message == '') {
            $this->session->set_flashdata('error', 'Nezadal si obsah správy.');
        } else {
            if ($this->ClubhousePost->createPost($id, $message)) {
                $this->session->set_flashdata('success', 'Príspevok bol pridaný.');
            } else {
                $this->session->set_flashdata('error', 'Príspevok sa nepodarilo pridať. Skúste to neskôr.');
            }
        }
        
        redirect('profile/race/' . $place); // redirect to the clubhouse
    }

}

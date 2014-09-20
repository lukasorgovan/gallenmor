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
     * @param string $place Clubhouse identification string
     */
    public function race($place) {
        $data['race'] = $place;

        if ($this->_isAuthorizedToVisit($place)) {
            // get clubhouse posts
            $data['posts'] = $this->ClubhousePost->getPosts($place);
        } else {
            $data['error'] = 'Nemáš postavu s danou rasou a preto nemôžem navštíviť túto klubovňu.';
        }

        $this->load->view('clubhouses/race', $data);
    }

    /**
     * Adds new post to a clubhouse
     */
    public function addPost() {
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

        redirect('clubhouses/race/' . $place); // redirect to the clubhouse
    }

    /**
     * Deletes a post from a clubhouse
     */
    public function deletePost() {
        $id = trim($this->input->post('id'));
        $place = trim($this->input->post('place'));

        if (!$this->_isAuthorizedToManage($id)) {
            $this->session->set_flashdata('error', 'Nemáš oprávnenie mazať tento príspevok.');
        } else if (!$id || $id == '') {
            $this->session->set_flashdata('error', 'Id príspevku nebolo zadané.');
        } else {
            if ($this->ClubhousePost->deletePost($id)) {
                $this->session->set_flashdata('success', 'Príspevok bol zmazaný.');
            } else {
                $this->session->set_flashdata('error', 'Príspevok sa nepodarilo zmazať. Skúste to neskôr.');
            }
        }

        redirect('clubhouses/race/' . $place); // redirect to the clubhouse
    }

    /**
     * Updates a post in a clubhouse
     */
    public function updatePost() {
        $message = trim($this->input->post('message'));
        $id = trim($this->input->post('id'));
        $place = trim($this->input->post('id'));

        if (!$this->_isAuthorizedToManage($id)) {
            $this->session->set_flashdata('error', 'Nemáš oprávnenie upravovať tento príspevok.');
        } else if ($message || $message == '') {
            $this->session->set_flashdata('error', 'Nezadal si obsah správy.');
        } else {
            if ($this->ClubhousePost->createPost($id, $message)) {
                $this->session->set_flashdata('success', 'Príspevok bol pridaný.');
            } else {
                $this->session->set_flashdata('error', 'Príspevok sa nepodarilo pridať. Skúste to neskôr.');
            }
        }

        redirect('clubhouses/race/' . $place); // redirect to the clubhouse
    }

    /**
     * Checks if the user has the right to visit the clubhouse
     * 
     * Note: A bit ugly. May need refactoring..
     */
    public function _isAuthorizedToVisit($place) {
        /* To-Do: Allow admin */

        $this->load->model('User');
        $races_arrays = $this->User->getAllRaces($this->session->userdata('id'));

        $races = array();
        foreach ($races_arrays as $arr) {
            array_push($races, $arr['race']);
        }

        return in_array($place, $races);
    }

    /**
     * Checks if the user has the right to do a action
     */
    public function _isAuthorizedToManage($id) {
        /* To-Do: Allow admin */

        $post = $this->ClubhousePost->getPost($id);

        return $post['user_id'] == $this->session->userdata('id');
    }

}

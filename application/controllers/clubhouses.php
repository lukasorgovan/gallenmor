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
        // get all races to show disabled links to not accessible clubhouses
        $data['user_races'] = $this->getAccessibleRaces();

        $this->load->view('clubhouses/index', $data);
    }

    /**
     * Displays specified clubhouse
     * 
     * @param string $place Clubhouse identification string
     */
    public function race($place) {
        $data['race'] = $place;

        // get all races to show disabled links to not accessible clubhouses
        $data['user_races'] = $this->getAccessibleRaces();

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
        $place = trim($this->input->post('place'));

        if (!$this->_isAuthorizedToManage($id)) {
            $this->session->set_flashdata('error', 'Nemáš oprávnenie upravovať tento príspevok.');
        } else if (!$message || $message == '') {
            $this->session->set_flashdata('error', 'Nezadal si obsah správy.');
        } else {
            if ($this->ClubhousePost->updatePost($id, $message)) {
                $this->session->set_flashdata('success', 'Príspevok bol aktualizovaný.');
            } else {
                $this->session->set_flashdata('error', 'Príspevok sa nepodarilo aktualizovať. Skúste to neskôr.');
            }
        }

        redirect('clubhouses/race/' . $place); // redirect to the clubhouse
    }

    /**
     * Display edit form to edit a post
     * 
     * @param int $id Id of the post to be edited
     */
    public function edit($id) {
        if (!$this->_isAuthorizedToManage($id)) {
            $data['error'] = 'Nemáš oprávnenie upravovať tento príspevok.';
        } else {
            $data['post'] = $this->ClubhousePost->getPost($id);
        }
        $this->load->view('clubhouses/edit', $data);
    }

    /**
     * Checks if the user has the right to visit the clubhouse
     * 
     * @param string $place Clubhouse identification string
     */
    public function _isAuthorizedToVisit($place) {
        /* To-Do: Allow admin */
        $races = $this->getAccessibleRaces();

        return in_array($place, $races);
    }

    /**
     * Checks if the user has the right to do a action
     * 
     * @param int $id Id of the post to be managed
     * @return boolean Condition if the user is able to manage a post
     */
    public function _isAuthorizedToManage($id) {
        /* To-Do: Allow admin */

        $post = $this->ClubhousePost->getPost($id);

        return $post['user_id'] == $this->session->userdata('id');
    }

    /**
     * Get all races of the characters a user has
     * Note: A bit ugly. May need refactoring..
     * 
     * @return array Array of races
     */
    private function getAccessibleRaces() {
        $this->load->model('User');
        $races_arrays = $this->User->getUserRaces($this->session->userdata('id'));

        $races = array();
        foreach ($races_arrays as $arr) {
            array_push($races, $arr['race']);
        }
        return $races;
    }

}

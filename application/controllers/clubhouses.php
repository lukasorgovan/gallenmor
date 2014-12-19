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
        $data['user_races'] = $this->ClubhousePost->getAccessibleRaces();

        // get description of what race clubhouses are
        $data['description'] = $this->ClubhousePost->getClubhouseDescription();

        $this->load->view('clubhouses/index', $data);
    }

    /**
     * Displays specified clubhouse
     * 
     * @param string $codename Clubhouse identification string
     */
    public function race($codename) {
        $data['race'] = $codename;

        // get all races to show disabled links to not accessible clubhouses
        $data['user_races'] = $this->ClubhousePost->getAccessibleRaces();

        // get metadata
        $data['metadata'] = $this->ClubhousePost->getClubhouseMeta($codename);

        if ($this->ClubhousePost->isAuthorizedToVisit($codename)) {
            // get clubhouse posts
            $data['posts'] = $this->ClubhousePost->getPosts($codename);
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
        $codename = trim($this->input->post('codename'));

        if (!$message || $message == '') {
            $this->session->set_flashdata('error', 'Nezadal si obsah správy.');
        } else {
            if ($this->ClubhousePost->createPost($message, $codename)) {
                $this->session->set_flashdata('success', 'Príspevok bol pridaný.');
            } else {
                $this->session->set_flashdata('error', 'Príspevok sa nepodarilo pridať. Skúste to neskôr.');
            }
        }

        redirect('clubhouses/race/' . $codename); // redirect to the clubhouse
    }

    /**
     * Deletes a post from a clubhouse
     */
    public function deletePost() {
        $id = trim($this->input->post('id'));
        $codename = trim($this->input->post('codename'));

        if (!$this->ClubhousePost->isAuthorizedToManage($id)) {
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

        redirect('clubhouses/race/' . $codename); // redirect to the clubhouse
    }

    /**
     * Updates a post in a clubhouse
     */
    public function updatePost() {
        $message = trim($this->input->post('message'));
        $id = trim($this->input->post('id'));
        $codename = trim($this->input->post('codename'));

        if (!$this->ClubhousePost->isAuthorizedToManage($id)) {
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

        redirect('clubhouses/race/' . $codename); // redirect to the clubhouse
    }

    /**
     * Display edit form to edit a post
     * 
     * @param int $id Id of the post to be edited
     */
    public function edit($id) {
        if (!$this->ClubhousePost->isAuthorizedToManage($id)) {
            $data['error'] = 'Nemáš oprávnenie upravovať tento príspevok.';
        } else {
            $data['post'] = $this->ClubhousePost->getPost($id);
        }
        $this->load->view('clubhouses/edit', $data);
    }

}

<?php

class Wall extends LoggedController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Wall_post');
    }

    /**
     * Default index action. 
     */
    public function index($page = 1) {
        $data['posts'] = $this->Wall_post->get_posts($page);
        $this->load->view('wall/index', $data);
    }

    /**
     * Adds new post to the database
     */
    public function create() {
        $title = trim($this->input->post('title'));
        $rpg_author = trim($this->input->post('rpg_author'));
        $message = trim($this->input->post('message'));
        $section = trim($this->input->post('section'));

        if (!$message || $message == '') {
            $this->session->set_flashdata('error', 'Nezadal si obsah správy.');
        } else {
            if ($this->Wall_post->create($title, $rpg_author, $message, $section)) {
                $this->session->set_flashdata('success', 'Príspevok bol pridaný.');
            } else {
                $this->session->set_flashdata('error', 'Príspevok sa nepodarilo pridať. Skúste to neskôr.');
            }
        }

        redirect('wall/' . $section_name);
    }

    /**
     * Deletes a post from the wall
     */
    public function delete() {
        $id = trim($this->input->post('id'));
        $section_code = trim($this->input->post('section_code'));

        if (!$this->Wall_post->is_authorized_to_manage($id)) {
            $this->session->set_flashdata('error', 'Nemáš oprávnenie mazať tento príspevok.');
        } else if (!$id || $id == '') {
            $this->session->set_flashdata('error', 'Id príspevku nebolo zadané.');
        } else {
            if ($this->Wall_post->delete($id)) {
                $this->session->set_flashdata('success', 'Príspevok bol zmazaný.');
            } else {
                $this->session->set_flashdata('error', 'Príspevok sa nepodarilo zmazať. Skúste to neskôr.');
            }
        }

        redirect('wall/' . $section_code); // redirect to the clubhouse
    }

    /**
     * Updates a post
     */
    public function update() {
        $id = trim($this->input->post('id'));
        $title = trim($this->input->post('title'));
        $rpg_author = trim($this->input->post('rpg_author'));
        $message = trim($this->input->post('message'));
        $section_code = trim($this->input->post('section_code'));

        if (!$this->Wall_post->is_authorized_to_manage($id)) {
            $this->session->set_flashdata('error', 'Nemáš oprávnenie upravovať tento príspevok.');
        } else if (!$message || $message == '') {
            $this->session->set_flashdata('error', 'Nezadal si obsah správy.');
        } else {
            if ($this->Wall_post->update($id, $title, $rpg_author, $message)) {
                $this->session->set_flashdata('success', 'Príspevok bol aktualizovaný.');
            } else {
                $this->session->set_flashdata('error', 'Príspevok sa nepodarilo aktualizovať. Skúste to neskôr.');
            }
        }

        redirect('wall/' . $section_code); // redirect to the clubhouse
    }

    /**
     * Display edit form to edit a post
     * 
     * @param int $id Id of the post to be edited
     */
    public function edit($id) {
        if (!$this->Wall_post->is_authorized_to_manage($id)) {
            $data['error'] = 'Nemáš oprávnenie upravovať tento príspevok.';
        } else {
            $data['post'] = $this->Wall_post->get_post($id);
        }
        $this->load->view('wall/edit', $data);
    }

}

<?php

class Clubhouses extends LoggedController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Clubhouse_post');
    }

    /**
     * Default index action. 
     * Displays static text with links to all race clubhouses
     */
    public function index() {
        // get all races to show disabled links to not accessible clubhouses
        $data['user_races'] = $this->session->userdata('races');

        // get description of what race clubhouses are
        $data['description'] = $this->Clubhouse_post->get_clubhouse_description();

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
        $data['user_races'] = $this->session->userdata('races');

        // get metadata
        $data['metadata'] = $this->Clubhouse_post->get_clubhouse_meta($codename);

        if ($this->Clubhouse_post->is_authorized_to_visit($codename)) {
            // get clubhouse posts
            $data['posts'] = $this->Clubhouse_post->get_posts($codename);
        } else {
            $data['error'] = 'Nemáš postavu s danou rasou a preto nemôžem navštíviť túto klubovňu.';
        }

        $this->load->view('clubhouses/race', $data);
    }

    /**
     * Adds new post to a clubhouse
     */
    public function create() {
        $message = trim($this->input->post('message'));
        $codename = trim($this->input->post('codename'));

        if (!$message || $message == '') {
            $this->session->set_flashdata('error', 'Nezadal si obsah správy.');
        } else {
            if ($this->Clubhouse_post->create($message, $codename)) {
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
    public function delete() {
        $id = trim($this->input->post('id'));
        $codename = trim($this->input->post('codename'));

        if (!$this->Clubhouse_post->is_authorized_to_manage($id)) {
            $this->session->set_flashdata('error', 'Nemáš oprávnenie mazať tento príspevok.');
        } else if (!$id || $id == '') {
            $this->session->set_flashdata('error', 'Id príspevku nebolo zadané.');
        } else {
            if ($this->Clubhouse_post->delete($id)) {
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
    public function update() {
        $message = trim($this->input->post('message'));
        $id = trim($this->input->post('id'));
        $codename = trim($this->input->post('codename'));

        if (!$this->Clubhouse_post->is_authorized_to_manage($id)) {
            $this->session->set_flashdata('error', 'Nemáš oprávnenie upravovať tento príspevok.');
        } else if (!$message || $message == '') {
            $this->session->set_flashdata('error', 'Nezadal si obsah správy.');
        } else {
            if ($this->Clubhouse_post->update($id, $message)) {
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
        if (!$this->Clubhouse_post->is_authorized_to_manage($id)) {
            $data['error'] = 'Nemáš oprávnenie upravovať tento príspevok.';
        } else {
            $data['post'] = $this->Clubhouse_post->get_post($id);
        }
        $this->load->view('clubhouses/edit', $data);
    }

}

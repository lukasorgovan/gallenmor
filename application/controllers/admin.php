<?php

class Admin extends LoggedController {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin_tools');
    }

    /**
     * Default index action. 
     * List of all administration tools.
     */
    public function index() {
        if ($this->session->userdata('authority') != 99) {
            redirect('profile/characters'); // redirect if not admin
        }

        $data['characters'] = $this->admin_tools->get_characters();
        $data['races'] = $this->admin_tools->get_races();
        $this->load->view('admin/index', $data);
    }

    /**
     * Update character's name
     */
    public function update_name() {
        $id = trim($this->input->post('character_id'));
        $name = trim($this->input->post('name'));

        if ($this->admin_tools->update_character($id, "charname", $name)) {
            $this->session->set_flashdata('success', 'Meno postavy bolo upravené.');
        } else {
            $this->session->set_flashdata('error', 'Meno postavy sa nepodarilo upraviť. Skúste to neskôr.');
        }

        redirect('admin');
    }

    /**
     * Update character's age
     */
    public function update_age() {
        $id = trim($this->input->post('character_id'));
        $age = trim($this->input->post('age'));

        if ($this->admin_tools->update_character($id, "age", $age)) {
            $this->session->set_flashdata('success', 'Vek postavy bol upravený.');
        } else {
            $this->session->set_flashdata('error', 'Vek postavy sa nepodarilo upraviť. Skúste to neskôr.');
        }

        redirect('admin');
    }

    /**
     * Update character's race
     */
    public function update_race() {
        $id = trim($this->input->post('character_id'));
        $race = trim($this->input->post('race'));

        if ($this->admin_tools->update_character($id, "race", $race)) {
            $this->session->set_flashdata('success', 'Rasa postavy bola upravená.');
        } else {
            $this->session->set_flashdata('error', 'Rasu postavy sa nepodarilo upraviť. Skúste to neskôr.');
        }

        redirect('admin');
    }

    /**
     * Update character's gender
     */
    public function update_gender() {
        $id = trim($this->input->post('character_id'));
        $gender = trim($this->input->post('gender'));

        if ($this->admin_tools->update_character($id, "gender", $gender)) {
            $this->session->set_flashdata('success', 'Pohlavie postavy bola upravené.');
        } else {
            $this->session->set_flashdata('error', 'Pohlavie postavy sa nepodarilo upraviť. Skúste to neskôr.');
        }

        redirect('admin');
    }

}

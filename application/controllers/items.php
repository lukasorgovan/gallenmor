<?php

class Items extends LoggedController {

    public function __construct() {
        parent::__construct();
        $this->load->model('item');
    }

    /**
     * Displays shop home page
     */
    public function index() {
        $data['admin'] = $this->_is_admin();
        $this->load->view('items/index', $data);
    }

    /**
     * Displays admin home page
     */
    public function admin() {
        $this->load->view('items/admin');
    }

    /**
     * Displays specific shop page
     */
    public function section($section = NULL) {
        $this->load->helper('html');

        if ($section == NULL) {
            show_404();
        } else {
            // Note: May need refactoring...
            switch ($section) {
                case "capes": $data['section'] = "Klubúky";
                    break;
                case "birds": $data['section'] = "Vtáky";
                    break;
                case "swords": $data['section'] = "Meče";
                    break;
                case "potions": $data['section'] = "Elixíry";
                    break;
                default: show_404();
                    break;
            }

            $data['admin'] = $this->_is_admin();
            $data['items'] = $this->item->get_items($section);
            $this->load->view('items/section', $data);
        }
    }

    /**
     * Creates new item
     */
    public function create() {
        if ($this->_is_admin()) {
            $name = trim($this->input->post('name'));
            // To-Do: File upload
            $img = NULL;
            $price = trim($this->input->post('price'));
            $quantity = trim($this->input->post('quantity'));
            $description = trim($this->input->post('description'));
            $usable = trim($this->input->post('usable'));
            $tradeable = trim($this->input->post('tradeable'));
            $type = trim($this->input->post('type'));
            $level = trim($this->input->post('level'));
            $char_required = trim($this->input->post('char_required_use_level'));
            $race_restriction = trim($this->input->post('race_restriction'));
            $durability = trim($this->input->post('durability'));
            $usages = trim($this->input->post('usages'));
            $stats = trim($this->input->post('stats'));

            if ($this->item->create($name, $img, $price, $quantity, $description, $usable, $tradeable, $type, $level, $char_required, $race_restriction, $durability, $usages, $stats)) {
                $this->session->set_flashdata('success', 'Item bol vytvorený');
            } else {
                $this->session->set_flashdata('error', 'Item sa nepodarilo pridať. Skúste to neskôr.');
            }

            redirect('items/admin');
        }
    }

    /**
     * Update an existing item
     */
    public function update() {
        if ($this->_is_admin()) {
            $id = trim($this->input->post('id'));
            $name = trim($this->input->post('name'));
            // To-Do: File upload
            $img = NULL;
            $price = trim($this->input->post('price'));
            $quantity = trim($this->input->post('quantity'));
            $description = trim($this->input->post('description'));
            $usable = trim($this->input->post('usable'));
            $tradeable = trim($this->input->post('tradeable'));
            $type = trim($this->input->post('type'));
            $level = trim($this->input->post('level'));
            $char_required = trim($this->input->post('char_required_use_level'));
            $race_restriction = trim($this->input->post('race_restriction'));
            $durability = trim($this->input->post('durability'));
            $usages = trim($this->input->post('usages'));
            $stats = trim($this->input->post('stats'));

            if ($this->item->edit($id, $name, $img, $price, $quantity, $description, $usable, $tradeable, $type, $level, $char_required, $race_restriction, $durability, $usages, $stats)) {
                $this->session->set_flashdata('success', 'Item bol aktualizovaný');
            } else {
                $this->session->set_flashdata('error', 'Item sa nepodarilo aktualizovať. Skúste to neskôr.');
            }

            redirect('items/edit/' . $id);
        }
    }

    /**
     * Delete an item
     * 
     * @param int $id Id of the item
     */
    public function delete($id = 1) {
        if ($this->_is_admin()) {
            if ($this->item->delete($id)) {
                $this->session->set_flashdata('success', 'Item bol zmazaný');
            } else {
                $this->session->set_flashdata('error', 'Item sa nepodarilo aktualizovať. Skúste to neskôr.');
            }

            redirect('items/admin/' . $id);
        }
    }

    /**
     * Display edit form
     * 
     * @param int $id Id of the item
     */
    public function edit($id = 1) {
        if ($this->_is_admin()) {
            $post = $this->item->get_item($id);
            $this->load->view('items/edit', $post);
        }
    }

    private function _is_admin() {
        // To-Do: Possible binding admin funcionality

        return $this->session->userdata('authority') == 99;
    }

}

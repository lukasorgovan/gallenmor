<?php

class Items extends LoggedController {

    public function __construct() {
        parent::__construct();
        $this->load->model('item');
    }

    /**
     * Displays Shop home page
     */
    public function index() {
        $this->load->view('items/index');
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

            $data['items'] = $this->item->get_items($section);
            $this->load->view('items/section', $data);
        }
    }

}

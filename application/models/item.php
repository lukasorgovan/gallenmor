<?php

class Item extends CI_Model {

    /**
     * Get items for specified section
     * @param type $id
     */
    public function get_items($section) {
        $sql = "SELECT i.*, r.name AS r_name FROM items i "
                . "LEFT JOIN races r "
                . "ON i.race_restriction = r.id "
                . "WHERE type = ?";
        $query = $this->db->query($sql, array(rtrim($section, 's')));
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }

}

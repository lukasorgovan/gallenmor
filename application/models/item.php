<?php

class Item extends CI_Model {

    /**
     * Create new item
     */
    public function create($name, $img, $price, $quantity, $description, $usable, $tradeable, $type, $level, $char_required, $race_restriction, $durability, $usages, $stats) {
        $sql = "INSERT INTO items (name, img, price, quantity, description,"
                . " usable, tradeable, type, level, char_required_use_level,"
                . " race_restriction, durability, usages, stats)"
                . " VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $this->db->trans_start();
        $this->db->query($sql, array($name, $img, $price, $quantity, $description, $usable, $tradeable, $type, $level, $char_required, $race_restriction, $durability, $usages, $stats));

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    /**
     * Update an item
     */
    public function edit($id, $name, $img, $price, $quantity, $description, $usable, $tradeable, $type, $level, $char_required, $race_restriction, $durability, $usages, $stats) {
        $sql = "UPDATE items SET name = ?, img = ?, price = ?, quantity =?,"
                . " description = ? , usable = ?, tradeable = ?, type = ?,"
                . " level = ?, char_required_use_level = ?, race_restriction = ?,"
                . " durability = ?, usages = ?, stats = ?"
                . " WHERE id = ?";
        $this->db->trans_start();
        $this->db->query($sql, array($name, $img, $price, $quantity, $description, $usable, $tradeable, $type, $level, $char_required, $race_restriction, $durability, $usages, $stats, $id));
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    /**
     * Delete an item
     */
    public function delete($id) {
        /* To-Do: Delete image on the disk */
        
        $sql = "DELETE FROM items WHERE id = ?";
        $this->db->trans_start();
        $this->db->query($sql, array($id));
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    /**
     * Get items for specified section
     * 
     * @param string $section Section identificator
     */
    public function get_items($section) {
        $sql = "SELECT i.*, r.name AS r_name FROM items i "
                . "LEFT JOIN races r "
                . "ON i.race_restriction = r.codename "
                . "WHERE type = ?";
        $query = $this->db->query($sql, array(rtrim($section, 's')));

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }

    /**
     * Get specific item
     * 
     * @param int $id Id of the item
     * @return array Item information
     */
    public function get_item($id) {
        $sql = "SELECT * FROM items WHERE id = ?";
        $query = $this->db->query($sql, array($id));

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return array();
    }

}

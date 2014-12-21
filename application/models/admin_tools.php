<?php

class Admin_tools extends CI_Model {

    public function get_users() {
        $sql = "SELECT id, username FROM users ORDER BY usernane ASC";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }

    public function get_characters() {
        $sql = "SELECT id, charname FROM characters ORDER BY charname ASC";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }

    public function get_races() {
        $sql = "SELECT name, codename FROM races ORDER BY id ASC";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }

    public function update_character($id, $column, $value) {
        $sql = "UPDATE characters SET " . $column . " = ? WHERE id = ?";
        $this->db->trans_start();
        $this->db->query($sql, array($value, $id));
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

}

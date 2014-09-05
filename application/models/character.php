<?php

class Character extends CI_Model {

    /**
     * Get all characters for specified user
     * 
     * @param type $user_id
     * @return type
     */
    function getCharactersForUser($user_id) {
        $sql = "SELECT * FROM characters WHERE id_user = ?";
        $query = $this->db->query($sql, array($user_id));

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }

    /**
     * Deletes user's character from database
     * 
     * @param type $id
     */
    function deleteCharacter($id) {
        // To-Do: Delete avatars from server

        $sql = "DELETE FROM characters WHERE id = ? AND id_user = ?";
        $this->db->trans_start();
        $this->db->query($sql, array($id, $this->session->userdata('id')));
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    /**
     * Crates new character from database
     * 
     * @param type $id
     */
    function addCharacter($race, $charname, $gender, $age) {
        $sql = "INSERT INTO characters (race, origin_race, charname, gender, age, id_user) VALUES (?, ?, ?, ?, ?, ?)";
        $this->db->trans_start();
        $this->db->query($sql, array($race, $race, $charname, $gender, $age, $this->session->userdata('id')));
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

}

<?php

class Character extends CI_Model {

    /**
     * Get all characters for specified user
     * 
     * @param type $user_id
     * @return type
     */
    function get_users_characters($user_id) {
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
    function delete($id) {
        // To-Do: Delete avatars from server

        $sql = "DELETE FROM characters WHERE id = ?";
        $this->db->trans_start();
        $this->db->query($sql, array($id));
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    /**
     * Crates new character from database
     * 
     * @param int $account_id Id of the account the character belongs to
     * @param string $race
     * @param string $charname
     * @param string $gender
     * @param int $age
     * @return boolean
     */
    function create($account_id, $race, $charname, $gender, $age) {
        $sql = "INSERT INTO characters (race, origin_race, charname, gender, age, id_user) VALUES (?, ?, ?, ?, ?, ?)";
        $this->db->trans_start();
        $this->db->query($sql, array($race, $race, $charname, $gender, $age, $account_id));
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

}

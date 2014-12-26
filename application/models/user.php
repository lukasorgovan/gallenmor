<?php

class User extends CI_Model {

    /**
     * Check if provided value is available
     * 
     * @param type $data name, email, etc.
     * @param type $table
     * @param type $column
     * @return type number of rows found for the username
     */
    function checkAvailibility($data, $table, $column) {
        $sql = "SELECT COUNT(*) AS pocet FROM {$table} WHERE {$column} = ?";
        $query = $this->db->query($sql, array($data));
        foreach ($query->result() as $row) {
            return $row->pocet;
        }
    }

    /**
     * Regiters new user
     * 
     * @param type $data
     * @param type $ip
     * @param type $salt
     * @return boolean
     */
    function registerUserChar($data, $ip, $salt) {
        if (is_array($data)) {
            // Perform transaction to register user and his character
            $sql_user = "INSERT INTO users (username, email, password, birthday, regip, salt) VALUES(?, ?, ?, ?, ?, ?)";
            $sql_character = "INSERT INTO characters (race, origin_race, charname, gender, age, id_user) VALUES(?, ?, ?, ?, ?, ?)";
            $sql_delete_generator = "DELETE FROM name_generator WHERE nickname = ?";
            $password = sha1($salt . $data['password'] . $salt);
            $this->db->trans_start();
            $this->db->query($sql_user, array($data['username'], $data['email'], $password, $data['date'], $ip, $salt));
            $this->db->query($sql_character, array($data['race'], $data['race'], $data['charname'], $data['gender'], $data['age'], $this->db->insert_id()));
            $this->db->query($sql_delete_generator, array($data['charname']));
            $this->db->trans_complete();

            return $this->db->trans_status();
        } else {
            return FALSE;
        }
    }

    /**
     * Tries to login an user
     * 
     * @param type $login login email
     * @param type $password login password
     * @return boolean login result
     */
    function login($login, $password) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $query = $this->db->query($sql, array($login));
        if ($query->num_rows() == 1) {
            foreach ($query->result() as $row) {
                // Check if password matches
                if (sha1($row->salt . $password . $row->salt) == $row->password) {
                    $this->session->set_userdata(array(
                        "id" => $row->id,
                        "username" => $row->username,
                        "email" => $row->email,
                        "gems" => $row->gems,
                        "allowed_to_play" => $row->allowed_to_play,
                        "birthday" => $row->birthday,
                        "forum_rank" => $row->forum_rank,
                        "avatar" => $row->avatar,
                        "banned" => $row->banned,
                        "authority" => $row->authority,
                        "races" => $this->getUserRaces($row->id),
                        "login_state" => TRUE
                    ));
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Get row from table for specified user
     * 
     * @param type $user_id
     * @return type
     */
    public function getUserData($user_id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        $query = $this->db->query($sql, array($user_id));

        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return array();
    }

    /**
     * Update account settings (email, password)
     * 
     * @param type $user_id
     * @param type $email
     * @param type $password
     * @param type $salt
     */
    public function updateAccountSetting($user_id, $email, $password) {
        $data = $this->getUserData($user_id);
        $salt = $data->salt;

        $sql_email = "UPDATE users SET email = ? WHERE id = ?";
        $sql_pass = "UPDATE users SET password = ? WHERE id = ?";

        $this->db->trans_start();
        $this->db->query($sql_email, array($email, $user_id));

        if ($password != '') {
            $password = sha1($salt . $password . $salt);
            $this->db->query($sql_pass, array($password, $user_id));
        }
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    /**
     * Returns list of all users
     * 
     * @param boolean $exclude_yourself Flag to exclude logged user from the list
     * @return type array of all users [id, username]
     */
    public function getAllUsers($exclude_yourself = false) {
        if ($exclude_yourself) {
            $sql = "SELECT id, username FROM users WHERE id <> ? ORDER BY username ASC";
            $query = $this->db->query($sql, array($this->session->userdata('id')));
        } else {
            $sql = "SELECT id, username FROM users ORDER BY username ASC";
            $query = $this->db->query($sql);
        }

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }

    /**
     *  Returns array of races the user's characters have
     * 
     * @param int $user_id
     */
    public function getUserRaces($user_id) {
        $sql = "SELECT race FROM characters WHERE id_user = ?";
        $query = $this->db->query($sql, array($user_id));

        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        } else {
            $data = array();
        }

        /* Note: This method may need more refactoring... */
        $races = array();
        foreach ($data as $race) {
            array_push($races, $race['race']);
        }
        return $races;
    }

}

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
                        "gems" => $row->gems,
                        "allowed_to_play" => $row->allowed_to_play,
                        "birthday" => $row->birthday,
                        "forum_rank" => $row->forum_rank,
                        "avatar" => $row->avatar,
                        "banned" => $row->banned,
                        "login_state" => TRUE
                    ));
                    return TRUE;
                } else {
                    return T;
                }
            }
        } else {
            return FALSE;
        }
    }

}

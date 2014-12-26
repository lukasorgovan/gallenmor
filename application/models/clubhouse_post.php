<?php

class Clubhouse_post extends CI_Model {

    /**
     * Create new post in a clubhouse
     *  
     * @param string $message Message content
     * @param string $codename Specific string identifying to which clubhouse the post belongs to
     * @return boolean If the post was successfuly created
     */
    public function create($message, $codename) {
        $sql = "INSERT INTO clubhouse_posts (user_id, message, codename) VALUES (?, ?, ?)";
        $this->db->trans_start();
        $this->db->query($sql, array($this->session->userdata('id'), $message, $codename));
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    /**
     * "Deletes" a post in the database. The post's flag deleted is marked so the
     * post will not be shown in the clubhouse it belongs to.
     * 
     * @param int $id Id of the post to be deleted
     * @return boolean If the post was successfuly deleted
     */
    public function delete($id) {
        $sql = "UPDATE clubhouse_posts SET deleted = 1 WHERE id = ?";
        $this->db->trans_start();
        $this->db->query($sql, array($id));
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    /**
     * Updates posts message in the database.
     * 
     * @param int $id Id of the post to be updated
     * @param string $message New content of the message
     * @return boolean If the post was successfuly updated
     */
    public function update($id, $message) {
        $sql = "UPDATE clubhouse_posts SET message = ? WHERE id = ?";
        $this->db->trans_start();
        $this->db->query($sql, array($message, $id));
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    /**
     * Returns clubhouse posts for specified clubhouse with optional parameters
     * 
     * @param string $codename Clubhouse identification string
     * @param int $page Number of posts page to be shown
     * @param int $per_page How many posts should be shown per page
     * @return array Array of posts
     */
    public function get_posts($codename, $page = 1, $per_page = 15) {
        $offset = ($page - 1) * $per_page;

        $sql = "SELECT c.*, u.username, u.avatar FROM clubhouse_posts c
            JOIN users u ON c.user_id = u.id
            WHERE codename = ? AND deleted = 0
            ORDER BY created DESC
            LIMIT ?, ?";
        $query = $this->db->query($sql, array($codename, $offset, $per_page));

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }

    /**
     * Get information for a post
     * 
     * @param int $id Id of the post
     * @return array Information about the post in an array
     */
    public function get_post($id) {
        $sql = "SELECT * FROM clubhouse_posts WHERE id = ?";
        $query = $this->db->query($sql, array($id));

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return array();
    }

    /**
     * Checks if the user has the right to visit the clubhouse
     * 
     * @param string $codename Clubhouse identification string
     */
    public function is_authorized_to_visit($codename) {
        return in_array($codename, $this->session->userdata('races')) || $this->session->userdata('authority') == 99;
    }

    /**
     * Checks if the user has the right to do a action
     * 
     * @param int $id Id of the post to be managed
     * @return boolean Condition if the user is able to manage a post
     */
    public function is_authorized_to_manage($id) {
        $post = $this->get_post($id);
        return $post['user_id'] == $this->session->userdata('id') || $this->session->userdata('authority') == 99;
    }

    /**
     * Get metadata (prolog text and name of the race) for a clubhouse.
     * 
     * @param string $codename Clubhouse identification string
     * @return array Array containing two information - prolog text and race name
     */
    public function get_clubhouse_meta($codename) {
        // get prolog text
        $sql = "SELECT * FROM texts WHERE label = ?";
        $query = $this->db->query($sql, array($codename));

        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $data['text'] = $result['content'];
        } else {
            $data['text'] = "";
        }

        // get race name
        $sql = "SELECT * FROM races WHERE codename = ?";
        $query = $this->db->query($sql, array($codename));

        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $data['name'] = $result['name'];
        } else {
            $data['name'] = "";
        }

        // return final data
        return $data;
    }

    public function get_clubhouse_description() {
        // get prolog text
        $sql = "SELECT * FROM texts WHERE label = 'races'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            return $result['content'];
        }
        return '';
    }

}

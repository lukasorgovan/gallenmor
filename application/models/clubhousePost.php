<?php

class ClubhousePost extends CI_Model {

    /**
     * Create new post in a clubhouse
     *  
     * @param string $message Message content
     * @param string $place Specific string identifying to which clubhouse the post belongs to
     * @return boolean If the post was successfuly created
     */
    public function createPost($message, $place) {
        $sql = "INSERT INTO clubhouse_posts (user_id, message, place) VALUES (?, ?, ?)";
        $this->db->trans_start();
        $this->db->query($sql, array($this->session->userdata('id'), $message, $place));
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
    public function deletePost($id) {
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
    public function updatePost($id, $message) {
        $sql = "UPDATE clubhouse_posts SET message = ? WHERE id = ?";
        $this->db->trans_start();
        $this->db->query($sql, array($message, $id));
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    /**
     * Returns clubhouse posts for specified clubhouse with optional parameters
     * 
     * @param string $place Clubhouse identification string
     * @param int $page Number of posts page to be shown
     * @param int $per_page How many posts should be shown per page
     * @return array Array of posts
     */
    public function getPosts($place, $page = 1, $per_page = 15) {
        $offset = ($page - 1) * $per_page;

        $sql = "SELECT c.*, u.username, u.avatar FROM clubhouse_posts c
            JOIN users u ON c.user_id = u.id
            WHERE place = ?
            ORDER BY created DESC
            LIMIT ?, ?";
        $query = $this->db->query($sql, array($place, $offset, $per_page));

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }

    public function getPost($id) {
        $sql = "SELECT * FROM clubhouse_posts WHERE id = ?";
        $query = $this->db->query($sql, array($id));

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return array();
    }

}

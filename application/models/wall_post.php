<?php

class Wall_post extends CI_Model {

    /**
     * Creates new post
     *  
     * @param string $message Message content
     * @param string $section Wall section (1 = RPG, 2 = Non-RPG, 3 = RL)
     * @return boolean If the post was successfuly created
     */
    public function create($title, $rpg_author, $message, $section) {
        $sql = "INSERT INTO wall_posts (user_id, title, rpg_author, message, section) VALUES (?, ?, ?, ?, ?)";
        $this->db->trans_start();
        $this->db->query($sql, array($this->session->userdata('id'), $title, $rpg_author, $message, $section));
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /**
     * "Deletes" a post in the database. The post's flag deleted is marked so the
     * post will not be shown but still is accessible in the database.
     * 
     * @param int $id Id of the post to be deleted
     * @return boolean If the post was successfuly deleted
     */
    public function delete($id) {
        $sql = "UPDATE wall_posts SET deleted = 1 WHERE id = ?";
        $this->db->trans_start();
        $this->db->query($sql, array($id));
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /**
     * Updates post's message in the database.
     * 
     * @param int $id Id of the post to be updated
     * @param string $title New content of the title
     * @param string $rpg_author New content of the rpg author
     * @param string $message New content of the message
     * @return boolean If the post was successfuly updated
     */
    public function update($id, $title, $rpg_author, $message) {
        
        $sql = "UPDATE wall_posts SET title = ?, rpg_author = ?, message = ? WHERE id = ?";
        $this->db->trans_start();
        $this->db->query($sql, array($title, $rpg_author, $message, $id));
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /**
     * Returns clubhouse posts for specified clubhouse with optional parameters
     * 
     * @param string $section  Wall section (1 = RPG, 2 = Non-RPG, 3 = RL)
     * @param int $page Number of posts page to be shown
     * @param int $per_page How many posts should be shown per page
     * @return array Array of posts
     */
    public function get_posts($section, $page = 1, $per_page = 15) {
        $offset = ($page - 1) * $per_page;
        $sql = "SELECT c.*, u.username FROM wall_posts c
            JOIN users u ON c.user_id = u.id
            WHERE section = ? AND deleted = 0
            ORDER BY created DESC
            LIMIT ?, ?";
        $query = $this->db->query($sql, array($section, $offset, $per_page));
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
        $sql = "SELECT * FROM wall_posts WHERE id = ?";
        $query = $this->db->query($sql, array($id));
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return array();
    }

    /**
     * Checks if the user has the right to do a action
     * 
     * @param int $id Id of the post to be managed
     * @return boolean Condition if the user is able to manage a post
     */
    public function is_authorized_to_manage($id) {
        if ($this->session->userdata('authority') == 99) {
            return true;
        }
        
        $post = $this->get_post($id);
        return $post['user_id'] == $this->session->userdata('id');
    }

}

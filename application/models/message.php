<?php

class Message extends CI_Model {

    /**
     * Returns all conversations (messages) for specified user
     * 
     * @param int $user_id User's id
     * @param int $page Pagination
     * @param int $per_page Pagination
     * @return type Array of conversations
     */
    public function get_received_messages($user_id, $page = 1, $per_page = 15) {
        // build query
        $offset = ($page - 1) * $per_page;

        $sql = "SELECT m.*, u1.username as u1username, u2.username as u2username,
            IF(
                from_user_id < to_user_id, 
                CONCAT(from_user_id, '-', to_user_id), 
                CONCAT(to_user_id, '-', from_user_id)
            ) as conversation_ids
            FROM messages m
            JOIN users u1 ON m.from_user_id = u1.id
            JOIN users u2 ON m.to_user_id = u2.id
            WHERE to_user_id = ? OR from_user_id = ?
            GROUP BY conversation_ids 
            ORDER BY created DESC
            LIMIT ?, ?";
        $query = $this->db->query($sql, array($user_id, $user_id, $offset, $per_page));

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }

    /**
     * Return conversation information for one message
     * @param type $id
     */
    public function get_conversation_info($id) {
        $sql = "SELECT from_user_id, to_user_id, created, u1.username AS u1username, u2.username AS u2username "
                . "FROM messages m "
                . "JOIN users u1 ON m.from_user_id = u1.id "
                . "JOIN users u2 ON m.to_user_id = u2.id "
                . "WHERE m.id = ? LIMIT 1";
        $query = $this->db->query($sql, array($id));

        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return array();
    }
    
    
    /**
     * Return conversation information for one message
     * @param type $id
     */
    public function get_messages($from_user_id, $to_user_id) {
        $sql = "SELECT from_user_id, to_user_id, created, message, u1.username AS u1username, u2.username AS u2username "
                . "FROM messages m "
                . "JOIN users u1 ON m.from_user_id = u1.id "
                . "JOIN users u2 ON m.to_user_id = u2.id "
                . "WHERE from_user_id IN (?, ?) AND to_user_id IN (?, ?) "
                . "ORDER BY created DESC";
        $query = $this->db->query($sql, array($from_user_id, $to_user_id, $from_user_id, $to_user_id));

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }

    /**
     * Adds new message to the database
     * 
     * @param int $from_id Id of the user who is sending the message
     * @param int $to_id Id of the user who will receive the message
     * @param int $message Message's content
     * @return boolean Result of transaction
     */
    public function send($from_id, $to_id, $message) {
        $sql = "INSERT INTO messages (from_user_id, to_user_id, message) VALUES (?, ?, ?)";
        $this->db->trans_start();
        $this->db->query($sql, array($from_id, $to_id, $message));
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

}

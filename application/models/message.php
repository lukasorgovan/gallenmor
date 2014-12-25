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
            WHERE to_user_id = ? OR from_user_id = ? AND delivered < ?
            GROUP BY conversation_ids 
            ORDER BY created DESC
            LIMIT ?, ?";
        $query = $this->db->query($sql, array($user_id, $user_id, time(), $offset, $per_page));

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
        $sql = "SELECT m.id, from_user_id, to_user_id, created, message, delivered, "
                . "u1.username AS u1username, u2.username AS u2username "
                . "FROM messages m "
                . "JOIN users u1 ON m.from_user_id = u1.id "
                . "JOIN users u2 ON m.to_user_id = u2.id "
                . "WHERE from_user_id IN (?, ?) AND to_user_id IN (?, ?) "
                . "ORDER BY id DESC";
        $query = $this->db->query($sql, array($from_user_id, $to_user_id, $from_user_id, $to_user_id, time()));

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
    public function send($from_id, $to_id, $message, $delivered) {
        // To-Do: Update user's inventory (take parchment etc.)

        $sql = "INSERT INTO messages (from_user_id, to_user_id, message, delivered) VALUES (?, ?, ?, ?)";
        $this->db->trans_start();
        $this->db->query($sql, array($from_id, $to_id, $message, $delivered));
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    /**
     * Returns unix timestamp when will the bird be available.
     */
    public function get_bird_availability() {
        // To-Do
        return (time() + 500);
    }

    /**
     * Test if user has enough supplies to write message
     * 
     * @return boolean
     */
    public function check_message_supplies() {
        // To-Do: check user's inventory

        return TRUE;
    }

    /**
     * Applies sending method
     * 
     * @param union $send_type {bird, post}
     * @return boolean Test if user had enough gold or food
     */
    public function send_type($send_type) {
        if ($send_type == 'bird') {
            // To-Do: update bird return type. update food
        } else {
            // To-Do: update gold
        }
        return TRUE;
    }

    /**
     * Calculates time when the message will be delivered
     * 
     * @return UNIX_TIMESTAMP
     */
    public function calculate_deliverey_time() {
        return time() + 60;
    }

}
